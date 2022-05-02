<?php

namespace App;

use App\Events\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Stevebauman\Purify\Facades\Purify;

/**
 * Eloquent Model: 'Thread'
 *
 * @property mixed                                                                                id
 * @property mixed                                                                                user_id
 * @property mixed                                                                                best_reply_id
 * @property mixed                                                                                title
 * @property mixed                                                                                updated_at
 * @property-read \App\Channel                                                                    $channel
 * @property-read \App\User                                                                       $creator
 * @property-read bool                                                                            $is_subscribed_to
 * @property-read DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\ReplyCollection|\App\Reply[]                                               $replies
 * @property-read mixed                                                                           $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ThreadSubscription[]              $subscriptions
 * @method static Builder|Thread filter($filters)
 * @mixin \Eloquent
 */
class Thread extends Model
{
    use RecordsActivity, Paginatable, Notifiable, Searchable;

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Always associate the model with...
     *
     * @var array
     */
    protected $with = ['creator', 'channel'];

    /**
     * Always append to the the array version of this model...
     *
     * @var array
     */
    protected $appends = ['isSubscribedTo', 'visits', 'hasUpdatesFor'];

    /**
     * The attributes that should be cast to JSON/Boolean.
     *
     * @var array
     */
    protected $casts = ['locked' => 'boolean'];

    /**
     * @var string
     */
    protected $indexConfigurator = ThreadIndexConfigurator::class;

    /**
     * @var array
     */
    protected $mapping = [
        'properties' => [
            'text' => [
                'type' => 'text',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ]
                ]
            ],
        ]
    ];

    /**
     * Laravel parent boot function.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::created(function ($thread) {
            $thread->update(['slug' => $thread->title]);
            $thread->creator->gainReputation('thread_published');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
            $thread->creator->loseReputation('thread_published');
        });
    }

    /**
     * Set the model key.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * A thread belongs to a creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A thread is assigned a channel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class)->withoutGlobalScope('active');
    }

    /**
     * A comment may have many replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * A thread can have a best reply.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bestReply()
    {
        return $this->hasOne(Reply::class, 'thread_id');
    }

    /**
     * Add a reply to the thread.
     *
     * @param array $reply
     * @return Model
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        $this->touch();

        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    /**
     * Return all relevant threads.
     *
     * @param Channel                   $channel
     * @param \App\Filters\ThreadFilter $filter
     * @param                           $offset
     * @return mixed
     */
    public static function getThreads($channel, $filter, $offset)
    {
        $threads = self::filter($filter)->limit(20)
                                        ->offset($offset)
                                        ->latest();

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->get();
    }

    /**
     * Mark a reply as the best as chosen by the thread creator.
     *
     * @param Reply $reply
     */
    public function markBestReply(Reply $reply)
    {
        if ($this->hasBestReply() && $this->bestReply !== $reply->id) {
            $this->bestReply->owner->loseReputation('best_reply_awarded');
        }

        $this->update(['best_reply_id' => $reply->id]);

        $reply->owner->gainReputation('best_reply_awarded');
    }

    /**
     * Unmark a reply that was marked as the best.
     */
    public function unmarkBestReply()
    {
        $this->update(['best_reply_id' => null]);

        $this->bestReply->owner->loseReputation('best_reply_awarded');
    }

    /**
     * Determine if the thread has a current best reply.
     *
     * @return bool
     */
    public function hasBestReply()
    {
        return !is_null($this->best_reply_id);
    }

    /**
     * Get a threaded set of replies.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getThreadedReplies()
    {
        return $this->getOrderedReplies()->get()->threaded();
    }

    /**
     * Get an ordered set of replies.
     *
     * @return ReplyCollection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getOrderedReplies()
    {
        $orderBy = $this->getOrderMethod();

        if ($orderBy[0] === "favourites_total") {
            return $this->getRepliesByFavourites($orderBy);
        }

        return $this->replies()->orderBy($orderBy[0], $orderBy[1]);
    }

    /**
     * Order data by the requested filter
     *
     * @return array
     */
    public function getOrderMethod()
    {
        $request = request('order-by');

        if ($request) {
            return explode(',', $request);
        }
    }

    /**
     * Get a set of replies ordered by favourites count.
     *
     * @param $orderBy
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getRepliesByFavourites($orderBy)
    {
        return $this->replies()
                    ->orderBy($orderBy[0], $orderBy[1])
                    ->orderBy("created_at", "asc");
    }

    /**
     * Get a paginated set of comments for root level replies.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginator()
    {
        return $this->getOrderedReplies()
                    ->where('parent_id', null)
                    ->paginate($this->getPerPage());
    }

    /**
     * Get the page number of a reply.
     *
     * @param int $id
     * @return int
     */
    public function getReplyPage($id)
    {
        return floor($this->getReplyIndex($id) / request('per-page')) + 1;
    }

    /**
     * Get the index of a reply.
     *
     * @param $id
     * @return int
     */
    public function getReplyIndex($id)
    {
        $replies = $this->getOrderedRootReplies();

        foreach ($replies as $index => $reply) {
            if ($id === $reply->id) {
                return $index;
            }
        }
    }

    /**
     * Get an ordered set of root level replies.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOrderedRootReplies()
    {
        return $this->getOrderedReplies()
                    ->where('parent_id', null)
                    ->get();
    }

    /**
     * Return instance of App\Visits.
     *
     * @return Visits
     */
    public function visits()
    {
        return new Visits($this);
    }

    /**
     * Get the thread visits count.
     *
     * @return int
     */
    public function getvisitsAttribute()
    {
        return $this->visits()->count();
    }

    /**
     * Subscribe a user to the current thread.
     *
     * @param int|null $userId
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    /**
     * A thread can have many subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * Unsubscribe a user from the current thread.
     *
     * @param int|null $userId
     */
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
             ->where('user_id', $userId ?: auth()->id())
             ->delete();
    }

    /**
     * Determine if the current user is subscribed to the thread.
     *
     * @return boolean
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
                    ->where('user_id', auth()->id())
                    ->exists();
    }

    /**
     * Determine whether the thread has been updated since a
     * user's last visit.
     *
     * @param $user
     * @return bool
     * @throws \Exception
     */
    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    /**
     * Return boolean indicating whether the thread has
     * been updated since a user's last visit.
     *
     * @return bool
     * @throws \Exception
     */
    public function gethasUpdatesForAttribute()
    {
        if (auth()->check()) {
            return $this->hasUpdatesFor(auth()->user());
        }

        return false;
    }

    /**
     * Apply all relevant thread filters.
     *
     * @param $query
     * @param $filters
     * @return Builder
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Set the proper slug attribute.
     *
     * @param string $value
     */
    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
            $slug = "{$slug}-{$this->id}";
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * Return array of search results
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->toArray() + ['path' => $this->path()];
    }

    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    /**
     * Purify the body.
     *
     * @param $body
     * @return string
     */
    public function getBodyAttribute($body)
    {
        return Purify::clean($body);
    }
}
