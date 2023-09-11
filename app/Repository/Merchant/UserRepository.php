<?php

namespace App\Repository\Merchant;

use App\Dto\Merchant\CreateUserDto;
use App\Models\Merchant\Merchant;

readonly class UserRepository
{
    /**
     * @param Merchant $model
     */
    public function __construct(
        private Merchant $model
    ) {}

    /**
     * @param CreateUserDto $dto
     * @return Merchant
     */
    public function create(CreateUserDto $dto): Merchant
    {
        return $this->model->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password
        ]);
    }

    /**
     * @param string $email
     * @return Merchant|null
     */
    public function findByEmail(string $email): ?Merchant
    {
        return $this->model->whereEmail($email)->first();
    }
}
