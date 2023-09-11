<?php

namespace App\Dto\Merchant;

readonly class RegistrationDto
{
    public function __construct(
        public string $name,
        public string $description,
        public string $email,
        public string $password,
        public ?int $id = null,
    ) {}
}
