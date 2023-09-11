<?php

namespace App\Dto\Merchant;

readonly class CreateUserDto
{
    public function __construct(
        public string $name,
        public string $description,
        public string $email,
        public string $password
    ) {}
}
