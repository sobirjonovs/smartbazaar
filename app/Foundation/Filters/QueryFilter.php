<?php

namespace App\Foundation\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Класс для фильтрации выборки Eloquent моделей.
 * Принимает в конструктор набор фильтров в виде массива.
 * Ключи массива преобразуются в названия методов данного класса в формате filter{КлючМассива},
 * которые вызываются по очереди.
 */
abstract class QueryFilter
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Данные запроса - очищенные от пустых значений.
     *
     * @var array
     */
    protected $input;

    /**
     * Фильтры по умолчанию.
     *
     * @var array
     */
    protected $defaults = [];

    /**
     * Поля доступные для поиска.
     *
     * @var array
     */
    protected $searchable = [];

    /**
     * Поля доступные для сортировки.
     *
     * @var array
     */
    protected $sortable = [];

    /**
     * Разрещить/запретить установку значения пагинации из запроса.
     *
     * @var bool
     */
    protected $perPageFromRequest = true;

    /**
     * Максимальное кол-во элеменотов на странице.
     *
     * @var int
     */
    protected $maxPerPage = 100;

    /**
     * QueryFilter constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $request = request()->merge($data);

        if (empty($this->rules())) {
            $data = $request->all();
        } else {
            $data = $request->validate($this->rules());
        }

        $this->input = $this->prepareInput($data);
    }

    /**
     * Хук перед выполнением фильтрации. Тут можно добавить join и т.д.
     */
    protected function before()
    {
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function addInput($key, $value)
    {
        $this->input[$key] = $value;
    }

    /**
     * @param $key
     * @return void
     */
    public function removeInput($key)
    {
        if (array_key_exists($key, $this->input)) {
            unset($this->input[$key]);
        }
    }

    /**
     * @return void
     */
    public function clearFilters($exceptKeys = [])
    {
        if (!empty($exceptKeys)) {
            $includeIndex = array_keys(array_filter($this->input, function ($item, $index) use ($exceptKeys) {
               return !in_array($index, $exceptKeys);
            }, ARRAY_FILTER_USE_BOTH));
            foreach ($includeIndex as $index) {
                unset($this->input[$index]);
            }
        } else {
            $this->input = [];
        }
    }

    /**
     * Применить фильтры к запросу.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        $this->before();

        foreach ($this->filters() as $name => $value) {
            $methodName = 'filter' . $this->toStudlyCaps($name);

            if (method_exists($this, $methodName)) {
                $this->$methodName($value);
            }
        }

        return $this->builder;
    }

    /**
     * Convert a value to studly caps case.
     *
     * @param  string  $value
     * @return string
     */
    protected function toStudlyCaps($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return str_replace(' ', '', $value);
    }

    /**
     * Получить фильтры.
     *
     * @return array
     */
    public function filters()
    {
        return $this->input;
    }

    /**
     * Rules for input data
     * @return array
     */
    protected function rules(): array
    {
        return [];
    }

    /**
     * Получить значение фильтра.
     *
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public function getInput($name, $default = null)
    {
        return $this->input[$name] ?? $default;
    }

    /**
     * Проверка существования фильтра.
     *
     * @param string $name
     * @return bool
     */
    public function hasInput($name)
    {
        return isset($this->input[$name]);
    }

    /**
     * Удаляет пустые значение из запроса.
     *
     * @param array $input
     * @return array
     */
    protected function prepareInput($input)
    {
        $filterableInput = [];

        $input = array_merge($this->defaults, $input);

        $input = $this->trimArray($input);

        foreach ($input as $key => $val) {
            if (!empty($val)) {
                $filterableInput[$key] = $val;
            }
        }

        return $filterableInput;
    }

    /**
     * Возвращает очищеный от пробелов массив.
     *
     * @param array $input
     * @return array
     */
    protected function trimArray(array $input)
    {
        $result = [];

        foreach ($input as $key => $val) {
            if (is_array($val)) {
                $result[$key] = $this->trimArray($val);
            } else {
                $result[$key] = trim($val);
            }
        }

        return $result;
    }

    /**
     * Получить массив полей доступных для сортировки.
     *
     * @return array
     */
    public function getSortable()
    {
        return $this->sortable;
    }

    /**
     * Получить массив полей доступных для поиска.
     *
     * @return array
     */
    public function getSearchable()
    {
        return $this->searchable;
    }

    /**
     * Проверят доступность поля для поиска.
     *
     * @param string $key
     * @return bool
     */
    protected function isSearchable($key)
    {
        return array_key_exists($key, $this->searchable);
    }

    /**
     * Проверят доступность поля для сортировки.
     *
     * @param $key
     * @return bool
     */
    protected function isSortable($key)
    {
        return array_key_exists($key, $this->sortable);
    }

    /**
     * Сортировка по определенному полю.
     *
     * @param $value
     */
    public function filterSort($value)
    {
        if ($this->isSortable($value)) {
            $type = $this->getInput('sort_type') === 'desc' ? 'desc' : 'asc';
            $this->builder->orderBy($value, $type);
        }
    }

    /**
     * Поиск по определенному полю.
     *
     * @param $value
     */
    public function filterSearch($value)
    {
        $searchIn = $this->getInput('search_in');

        if ($searchIn && $this->isSearchable($searchIn)) {
            $this->builder->where($searchIn, 'LIKE', '%' . $value . '%');
        }
    }

    /**
     * Устанавливает количество элементов на странице при пагинации.
     *
     * @param $value
     */
    public function filterPerPage($value)
    {
        if (!$this->perPageFromRequest) {
            return;
        }

        $perPage = (int) $value;

        if ($perPage > $this->maxPerPage) {
            $perPage = $this->maxPerPage;
        }

        if ($perPage) {
            $this->builder->getModel()->setPerPage($perPage);
        }
    }

    /**
     * @param $value
     * @return void
     */
    public function filterLimit($value)
    {
        $this->filterPerPage($value);
    }
}
