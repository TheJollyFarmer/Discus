<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent Model: 'Conversation'
 *
 * @property-read \App\Group $group
 * @property-read \App\User  $user
 * @mixin \Eloquent
 */
class Conversation extends Model
{
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $fillable = ['message', 'user_id', 'group_id'];

    /**
     * Always associate the model with...
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * A conversation belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A conversation belongs to a group of users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
