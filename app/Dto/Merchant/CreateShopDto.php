<?php

namespace App\Dto\Merchant;

use App\Enums\ShopStatus;

readonly class CreateShopDto
{
    public function __construct(
        public string $address,
        public string $schedule,
        public float $latitude,
        public float $longitude,
        public string $status = ShopStatus::ACTIVE->value
    ) {}
}
