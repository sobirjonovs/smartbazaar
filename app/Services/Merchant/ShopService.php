<?php

namespace App\Services\Merchant;

use App\Dto\Merchant\CreateShopDto;
use App\Models\Merchant\Shop;
use App\Repository\Merchant\ShopRepository;
use Illuminate\Database\Eloquent\Model;

class ShopService
{
    /**
     * @param ShopRepository $repository
     */
    public function __construct(
        public ShopRepository $repository,
    ) {}

    /**
     * @param CreateShopDto $dto
     * @return Model|Shop
     */
    public function create(CreateShopDto $dto): Model|Shop
    {
        return $this->repository->create($dto);
    }
}
