<?php

namespace App\Filters;

use App\User;

class ReplyFilter extends Filter
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['by', 'popular'];

    /**
     * Filter the query by a given username.
     *
     * @param string $username
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to popularity.
     *
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function popular($value)
    {
        if ($value == 1) {
            return $this->builder->orderBy('replies_count', 'desc');
        } else {
            return $this->builder;
        }
    }
}
