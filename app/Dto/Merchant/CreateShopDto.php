<?php

namespace App\Dto\Merchant;

use App\Enums\ShopStatus;

readonly class CreateShopDto
{
    public function __construct(
        public int $merchant_id,
        public string $address,
        public string $schedule,
        public float $latitude,
        public float $longitude,
        public ?string $status = ShopStatus::ACTIVE->value,
        public ?int $id = null,
    ) {}
}
