<?php

namespace App\Filters;

use App\Foundation\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class ShopFilter extends QueryFilter
{
    /**
     * @return void
     */
    protected function before(): void
    {
        $this->builder
            ->selectRaw('shops.*')
            ->selectRaw('(6371 * 2 * ASIN(SQRT(POW(SIN((RADIANS(latitude - ?)) / 2), 2) + COS(RADIANS(?)) * COS(RADIANS(latitude)) * POW(SIN((RADIANS(longitude - ?)) / 2), 2)))) AS distance', [
                $this->getInput('user_latitude'),
                $this->getInput('user_latitude'),
                $this->getInput('user_longitude'),
            ])
            ->orderBy('distance', 'ASC')
            ->join('merchants', 'shops.merchant_id', '=', 'merchants.id');
    }

    /**
     * @param $value
     * @return Builder
     */
    public function filterAddress($value): Builder
    {
        return $this->builder->where('address', 'ilike', '%' . $value . '%');
    }

    /**
     * @param $value
     * @return Builder|void
     */
    public function filterLocation($value)
    {
        if (!is_array($value) || count($value) !== 2) {
            return;
        }

        return $this->builder
            ->where(function ($query) use ($value) {
                $query->where('latitude', $value[0])->where('longitude', $value[1]);
            })
            ->orWhere(function ($query) use ($value) {
                $query->where('latitude', $value[1])->where('longitude', $value[0]);
            });
    }

    /**
     * @param $value
     * @return Builder
     */
    public function filterId($value): Builder
    {
        return $this->builder->where('shops.id', $value);
    }

    /**
     * @param $value
     * @return Builder
     */
    public function filterMerchantId($value): Builder
    {
        return $this->builder->where('merchant_id', $value);
    }
}
