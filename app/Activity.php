<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent Model: 'Activity'
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $subject
 * @mixin \Eloquent
 */
class Activity extends Model
{
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['favouritedModel'];

    /**
     * Fetch the associated subject for the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Fetch the model record for the subject of the favorite.
     */
    public function getFavouritedModelAttribute()
    {
        $favouritedModel = null;

        if ($this->subject_type === Favourite::class) {
            $subject = $this->subject()->firstOrFail();
            if ($subject->favourited_type == Reply::class) {
                $favouritedModel = Reply::find($subject->favourited_id);
            }
        }
        return $favouritedModel;
    }

    /**
     * Fetch an activity feed for the given user.
     *
     * @param User $user
     * @param      $offset
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public static function feed($user, $offset)
    {
        return static::where('user_id', $user->id)
                     ->latest()
                     ->with('subject')
                     ->limit(10)
                     ->offset($offset)
                     ->get()
                     ->groupBy([function ($activity) {
                         return $activity->created_at->format('Y');
                     }, function ($activity) {
                         return $activity->created_at->format('F');
                     }]);
    }
}
