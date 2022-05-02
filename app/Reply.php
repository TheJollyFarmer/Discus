<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Facades\Purify;

/**
 * Eloquent Model: 'Reply'
 *
 * @property mixed                                                          id
 * @property mixed                                                          user_id
 * @property mixed                                                          $body
 * @property mixed                                                          updated_at
 * @property mixed                                                          created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Favourite[] $favourites
 * @property-read bool                                                      $can_update
 * @property-read int                                                       $favourites_count
 * @property-read bool                                                      $is_favourited
 * @property-read \App\User                                                 $owner
 * @property-read \App\Thread                                               $thread
 * @mixin \Eloquent
 */
class Reply extends Model
{
    use Favouritable, RecordsActivity;

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
    protected $with = ['owner', 'favourites', 'replies', 'thread'];

    /**
     * Always append to the the array version of this model...
     *
     * @var array
     */
    protected $appends = ['isFavourited'];

    /**
     * Boot the reply instance.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->owner->gainReputation('reply_posted');
        });

        static::deleting(function ($reply) {
            $reply->owner->loseReputation('reply_posted');

            if ($reply->isMarkedBest()) {
                $reply->thread->unmarkBestReply($reply);
            }
        });
    }

    /**
     * A reply has an owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {

        return $this->belongsTo(User::class, 'user_id')->select(['id', 'name', 'avatar_path']);
    }

    /**
     * A reply has many replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class, 'parent_id');
    }

    /**
     * A reply belongs to a thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Get the link data for a reply.
     *
     * @return array
     */
    public function linkData()
    {
        return [
            'page' => $this->page(),
            'hash' => "comment-{$this->id}"
        ];
    }

    /**
     * Get the page number for a reply.
     *
     * @return Int
     */
    public function page()
    {
        return $this->thread->getReplyPage($this->id);
    }

    /**
     * Determine whether the reply was just published.
     *
     * @return bool
     */
    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    /**
     * Fetch all mentioned users within the reply's body.
     *
     * @return array
     */
    public function taggedUsers()
    {
        preg_match_all('/@([\w\-]+)/u', $this->body, $matches);

        return $matches[1];
    }

    public function isMarkedBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    /**
     * Use a custom collection for all replies.
     *
     * @param array $models
     * @return ReplyCollection
     */
    public function newCollection(array $models = [])
    {
        return new ReplyCollection($models);
    }

    /**
     * Hyperlink any reference to users found in the body.
     *
     * @param $body
     */
    public function setBodyAttribute($body)
    {
        $tags = '/@([\w\-]+)/u';
        $tagLink = '<a href="/profiles/$1">$0</a>';

        $this->attributes['body'] = preg_replace($tags, $tagLink, $body);
    }

    public function getBodyAttribute($body)
    {
        return Purify::clean($body);
    }
}
