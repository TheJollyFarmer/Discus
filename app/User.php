<?php

namespace App;

use App\DatabaseNotification\ModifiedDatabaseNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

/**
 * Eloquent Model: 'User'
 *
 * @property mixed                                                         id
 * @property mixed                                                         name
 * @property bool                                                          verified
 * @property null                                                          verification_token
 * @property-read mixed                                                    $avatar_path
 * @property-read mixed                                                    $blocked_friends
 * @property-read mixed                                                    $friends
 * @property-read \App\Reply                                               $lastReply
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Group[]    $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]     $invited
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]     $invitedBy
 * @property-read \App\DatabaseNotification\ModifiedDatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Thread[]   $threads
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, Reputation, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'verification_token'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'isAdmin'
    ];

    /**
     * The attributes that should be cast to JSON/Boolean.
     *
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
        'points' => 'integer'
    ];

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * A user may have many threads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * A user may have a last reply.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    /**
     * A user may have many activities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get the user's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(ModifiedDatabaseNotification::class, 'notifiable')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * A user belongs to a group.
     *
     * @param $type
     * @param $users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hasGroup($type, $users)
    {
        return $this->groups()
                    ->where('type', $type)
                    ->whereHas('users', function ($group) use ($users) {
                        $group->where('user_id', $users);
                    });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }

    /**
     * Confirm a user is verified.
     */
    public function verify()
    {
        $this->verified = true;
        $this->verification_token = null;
        $this->save();
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return in_array(
            strtolower($this->email),
            array_map('strtolower', config('discus.administrators'))
        );
    }

    /**
     * @param $avatar
     * @return string
     */
    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ?: '/avatars/default.png');
    }

    /**
     * Set the visited-thread cache key.
     *
     * @param Thread $thread
     * @throws \Exception
     */
    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }

    /**
     * Get the visited-thread cache key.
     *
     * @param Thread $thread
     * @return string
     */
    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }

    /**
     * @return mixed
     */
    public function getFriendsAttribute()
    {
        if (!array_key_exists('friends', $this->relations)) {
            $this->loadFriends();
        }

        return $this->getRelation('friends');
    }

    /**
     * Set friends relation.
     */
    protected function loadFriends()
    {
        if (!array_key_exists('friends', $this->relations)) {
            $friends = $this->mergeFriends();

            $this->setRelation('friends', $friends);
        }
    }

    /**
     * @return mixed
     */
    protected function mergeFriends()
    {
        if ($this->friendss) {
            return $this->friendss->merge($this->friendsOf);
        }

        return $this->friendsOf;
    }

    /**
     * @return mixed
     */
    public function getBlockedFriendsAttribute()
    {
        if (!array_key_exists('blocked_friends', $this->relations)) {
            $this->loadBlockedFriends();
        }

        return $this->getRelation('blocked_friends');
    }

    /**
     * Fetch blocked_friends relation.
     */
    protected function loadBlockedFriends()
    {
        if (!array_key_exists('blocked_friends', $this->relations)) {
            $this->setRelation('blocked_friends', $this->mergeBlockedFriends());
        }
    }

    /**
     * @return mixed
     */
    protected function mergeBlockedFriends()
    {
        if ($this->blocked) {
            return $this->blocked->merge($this->blockedBy);
        }

        return $this->blockedBy;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friendRequests()
    {
        return $this->invitedBy()
                    ->withPivot('status', 'id')
                    ->wherePivot('status', 'pending')
                    ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function invitedBy()
    {
        return $this->belongsToMany(
            User::class,
            'friendships',
            'second_user',
            'first_user'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friendStatusTo()
    {
        return $this->invited()
                    ->withPivot('status', 'id')
                    ->where('second_user', auth()->id());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function invited()
    {
        return $this->belongsToMany(
            User::class,
            'friendships',
            'first_user',
            'second_user'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friendStatusFrom()
    {
        return $this->invitedBy()
                    ->withPivot('status', 'id')
                    ->where('first_user', auth()->id());
    }

    /**
     * @return mixed
     */
    public function friendStatus()
    {
        if ($this->friendStatusTo->isNotEmpty()) {
            return $this->friendStatusTo;
        }

        return $this->friendStatusFrom;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected function friendss()
    {
        return $this->invited()
                    ->withPivot('status')
                    ->wherePivot('status', 'confirmed');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected function friendsOf()
    {
        return $this->invitedBy()
                    ->withPivot('status')
                    ->wherePivot('status', 'confirmed');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected function blocked()
    {
        return $this->invited()
                    ->withPivot('status', 'acted_user')
                    ->wherePivot('status', 'blocked')
                    ->wherePivot('acted_user', 'first_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected function blockedBy()
    {
        return $this->invitedBy()
                    ->withPivot('status', 'acted_user')
                    ->wherePivot('status', 'blocked')
                    ->wherePivot('acted_user', 'second_user');
    }
}
