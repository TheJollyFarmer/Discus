<?php

namespace App;

trait Paginatable
{
    /**
     * @var int
     */
    private $pageSizeLimit = 50;

    /**
     * Set the number of replies per page for pagination.
     *
     * @return mixed
     */
    public function getPerPage()
    {
        $pageSize = request('per-page', $this->perPage);
        session(['per-page' => $pageSize]);

        return min($pageSize, $this->pageSizeLimit);
    }
}
