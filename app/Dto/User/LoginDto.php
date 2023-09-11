<?php

namespace App\Dto\User;

readonly class LoginDto
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
