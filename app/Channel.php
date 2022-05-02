<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 'App\Channel'
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Thread[] $threads
 * @mixin \Eloquent
 */
class Channel extends Model
{
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Always append to the the array version of this model...
     *
     * @var array
     */
    protected $appends = ['threadsCount'];

    /**
     * Attributes to cast.
     */
    protected $casts = ['archived' => 'boolean'];

    /**
     * Boot the channels model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('active', function ($builder) {
            $builder->where('archived', false);
        });

        static::addGlobalScope('sorted', function ($builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * A channel consists of threads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * Archive the channel.
     */
    public function archive()
    {
        $this->update(['archived' => true]);
    }

    /**
     * Set the name of the channel.
     *
     * @param string $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = str_slug($name);
    }

    /**
     * Get a new query builder that includes archives.
     */
    public static function withArchived()
    {
        return (new static)->newQueryWithoutScope('active');
    }

    /**
     * Return the thread count for a channel
     *
     * @return int
     */
    public function getThreadsCountAttribute()
    {
        return $this->threads()->count();
    }
}
