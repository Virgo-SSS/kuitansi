<?php

namespace App\Services;

use App\Pagination\CustomLengthAwarePaginator;
use http\Exception\InvalidArgumentException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PaginatorService
{
    protected Collection $items;

    protected int $perPage;

    protected int $total;

    protected int $lastPage;

    protected int $currentPage;

    protected string $path = '/';

    public function merge(array $paginators): static
    {
        foreach ($paginators as $paginator) {
            if (!$paginator instanceof LengthAwarePaginator) {
                throw new InvalidArgumentException("Only LengthAwarePaginator may be merged.");
            }
        }

        $total = 0;
        $highest_lastPage = 0;
        $perPage = 0;
        $currentPage = 1;
        array_reduce($paginators, function($carry, $paginator) use (&$total, &$highest_lastPage, &$perPage, &$currentPage) {
            $total += $paginator->total();

            if ($paginator->lastPage() > $highest_lastPage) $highest_lastPage = $paginator->lastPage();

            $perPage += $paginator->perPage();
            $currentPage = $paginator->currentPage();
        }, 0);

        $items = array_map(function($paginator) {
            return $paginator->items();
        }, $paginators);

        $items         = Arr::flatten($items);

        $items         = Collection::make($items);

        $this->items   = $items;
        $this->perPage = $perPage;
        $this->total   = $total;
        $this->lastPage = $highest_lastPage;
        $this->currentPage = $currentPage;

        return $this;
    }

    public function sortBy(callable|string $callback, int $options = SORT_REGULAR, bool $descending = false): static
    {
        $this->items = $this->items->sortBy($callback, $options, $descending);

        return $this;
    }

    public function sortByDesc(callable|string $callback, int $options = SORT_REGULAR): static
    {
        return $this->sortBy($callback, $options, true);
    }

    public function get(): LengthAwarePaginator
    {
        $paginator = new CustomLengthAwarePaginator(
            $this->items,
            $this->total,
            $this->perPage,
            $this->currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ],
        );

        $paginator = $paginator->setLastPage($this->lastPage);

        return $paginator;
    }
}
