<?php

namespace App\Dto\Admin;

readonly class LoginDto
{
    public function __construct(
        public string $username,
        public string $password
    ) {}
}
