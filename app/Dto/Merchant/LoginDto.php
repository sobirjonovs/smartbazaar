<?php

namespace App\Dto\Merchant;

readonly class LoginDto
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
