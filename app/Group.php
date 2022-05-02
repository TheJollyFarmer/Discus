<?php

namespace App;

use App\Events\GroupCreated;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent Model: 'Group'
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Conversation[] $messages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]         $users
 * @mixin \Eloquent
 */
class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $with = ['users'];

    /**
     * Laravel parent boot function.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($group) {
            $group->users->each->detach();
            $group->messages->each->delete();
        });
    }

    /**
     * A group may have many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function messages()
    {
        return $this->hasMany(Conversation::class)->latest();
    }

    /**
     * A group has one most recent message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Query\Builder
     */
    public function latestMessage()
    {
        return $this->hasOne(Conversation::class)->where('user_id', '!=', auth()->id())->latest();
    }

    /**
     * A group belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * A group belongs to many users.
     *
     * @param $group
     * @param $users
     * @return void
     */
    public function addUsers($group, $users)
    {
        $users = collect($users);

        $users->push(auth()->user()->id);

        $group->users()->attach($users);

        broadcast(new GroupCreated($group))->toOthers();
    }

    /**
     * A group has users other than the auth user.
     *
     * @param $type
     * @param $users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hasUsers($type, $users)
    {
        return $this->where('type', $type)->whereHas('users', function ($group) use ($users) {
            $group->where('user_id', $users);
        });
    }

    /**
     * Check if a particular user exists in a group.
     *
     * @param $user_id
     * @return bool
     */
    public function hasUser($user_id)
    {
        foreach ($this->users as $user) {
            if ($user->id == $user_id) {
                return true;
            }
        }
    }
}
