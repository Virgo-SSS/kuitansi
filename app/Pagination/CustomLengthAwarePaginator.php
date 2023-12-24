<?php

namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

class CustomLengthAwarePaginator extends LengthAwarePaginator
{
    public function __construct($items, $total, $perPage, $currentPage = null, array $options = [])
    {
        parent::__construct($items, $total, $perPage, $currentPage, $options);
    }

    public function setLastPage(int $lastPage): static
    {
        $this->lastPage = $lastPage;

        return $this;
    }
}
