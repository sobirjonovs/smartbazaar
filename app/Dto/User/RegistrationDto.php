<?php

namespace App\Dto\User;

readonly class RegistrationDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}
}
