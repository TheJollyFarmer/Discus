<?php

namespace App;

trait Favouritable
{
    /**
     * Laravel parent boot function.
     */
    protected static function bootFavouritable()
    {
        static::deleting(function ($model) {
            $model->favourites->each->delete();
        });
    }

    /**
     * A reply can be favourited.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favourited');
    }

    /**
     * Favourite a reply.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function favourite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favourites()->where($attributes)->exists()) {
            $this->where('id', $this->id)->increment('favourites_total');

            return $this->favourites()->create($attributes);
        }
    }

    /**
     * Unfavourite the current reply.
     */
    public function unfavourite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->where('id', $this->id)->decrement('favourites_total');
        $this->favourites()->where($attributes)->get()->each->delete();
    }

    /**
     * Determine if the current reply has been favourited.
     *
     * @return boolean
     */
    public function isFavourited()
    {
        return $this->favourites->where('user_id', auth()->id())->count();
    }

    /**
     * Fetch the favourited status as a property.
     *
     * @return bool
     */
    public function getIsFavouritedAttribute()
    {
        return $this->isFavourited();
    }

    /**
     * Get the number of favorites for the reply.
     *
     * @return integer
     */
    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }
}
