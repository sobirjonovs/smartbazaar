<?php

namespace App\Repository\Merchant;

use App\Dto\Merchant\CreateShopDto;
use App\Models\Merchant\Shop;
use Illuminate\Database\Eloquent\Model;

readonly class ShopRepository
{
    /**
     * @param Shop $model
     */
    public function __construct(
        private Shop $model
    ) {}

    /**
     * @param CreateShopDto $dto
     * @return Model|Shop
     */
    public function create(CreateShopDto $dto): Model|Shop
    {
        return $this->model->create([
            'address' => $dto->address,
            'schedule' => $dto->schedule,
            'latitude' => $dto->latitude,
            'longitude' => $dto->longitude,
            'status' => $dto->status
        ]);
    }
}
