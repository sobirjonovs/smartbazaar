<?php

namespace App\Repository\User;

use App\Dto\User\CreateUserDto;
use App\Models\User\User;

readonly class UserRepository
{
    /**
     * @param User $model
     */
    public function __construct(
        public User $model,
    ) {}

    /**
     * @param CreateUserDto $dto
     * @return User
     */
    public function create(CreateUserDto $dto): User
    {
        return $this->model->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password
        ]);
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->whereEmail($email)->first();
    }
}
