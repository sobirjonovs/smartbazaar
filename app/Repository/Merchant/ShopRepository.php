<?php

namespace App\Repository\Merchant;

use App\Dto\Merchant\CreateShopDto;
use App\Enums\ShopStatus;
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
    public function createOrUpdate(CreateShopDto $dto): Model|Shop
    {
        return $this->model->updateOrCreate([
            'id' => $dto->id
        ], [
            'merchant_id' => $dto->merchant_id,
            'address' => $dto->address,
            'schedule' => $dto->schedule,
            'latitude' => $dto->latitude,
            'longitude' => $dto->longitude,
            'status' => $dto->status ?? ShopStatus::ACTIVE
        ]);
    }
}
