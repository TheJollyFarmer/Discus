<?php

namespace App\Inspections;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Inspections\Spam
 *
 * @mixin \Eloquent
 */
class Spam extends Model
{
    /**
     * All registered inspections.
     *
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    /**
     * Detect spam.
     *
     * @param $body
     * @return bool
     */
    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}
