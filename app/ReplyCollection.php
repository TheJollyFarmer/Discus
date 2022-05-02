<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;

class ReplyCollection extends Collection
{
    /**
     * Thread the comment tree.
     *
     * @return Collection
     */
    public function threaded()
    {
        $replies = parent::groupBy('parent_id');

        if (count($replies)) {
            $replies['root'] = $replies[''];
            unset($replies['']);
        }

        return $replies->forget('root');
    }
}
