<?php

namespace App\Foundation\Filters\Concerns;

use App\Foundation\Filters\QueryFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @var QueryFilter|null
     */
    protected $filters;

    /**
     * Подготовленный запрос для фильрации.
     *
     * @param $query Builder
     * @param QueryFilter $filters
     * @return Builder
     */
    public function scopeFilter($query, $filters)
    {
        $this->filters = $filters;

        return $filters->apply($query);
    }

    /**
     * Добавляет к пагинации параметры фильтров.
     *
     * @param Builder $query
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function scopePaginateFilter($query, $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $perPage = $perPage ?: $query->getModel()->getPerPage();

        $paginator = $query->paginate($perPage, $columns, $pageName, $page);

        if ($this->filters !== null) {
            $paginator->appends($this->filters->filters());
        }

        return $paginator;
    }

    /**
     * Добавляет к пагинации параметры фильтров.
     *
     * @param Builder $query
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @return Paginator
     */
    public function scopeSimplePaginateFilter($query, $perPage = null, $columns = ['*'], $pageName = 'page')
    {
        $perPage = $perPage ?: $query->getModel()->getPerPage();

        $paginator = $query->simplePaginate($perPage, $columns, $pageName);

        if ($this->filters !== null) {
            $paginator->appends($this->filters->filters());
        }

        return $paginator;
    }
}
