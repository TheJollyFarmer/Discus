<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent Model 'Favourite'
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $favourited
 * @mixin \Eloquent
 */
class Favourite extends Model
{
    use RecordsActivity;

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Favourite an instance of a model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favourited()
    {
        return $this->morphTo();
    }
}
