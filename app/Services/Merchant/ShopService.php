<?php

namespace App\Services\Merchant;

use App\Dto\Merchant\CreateShopDto;
use App\Models\Merchant\Shop;
use App\Repository\Merchant\ShopRepository;
use Illuminate\Database\Eloquent\Model;

readonly class ShopService
{
    /**
     * @param ShopRepository $repository
     */
    public function __construct(
        private ShopRepository $repository,
    ) {}

    /**
     * @param CreateShopDto $dto
     * @return Model|Shop
     */
    public function createOrUpdate(CreateShopDto $dto): Model|Shop
    {
        return $this->repository->createOrUpdate($dto);
    }
}
