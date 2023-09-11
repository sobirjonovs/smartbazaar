<?php

namespace App\Dto\Merchant;

readonly class MerchantDto
{
    public function __construct(
        public string $name,
        public string $description,
        public string $email,
        public ?int $id = null,
    ) {}
}
