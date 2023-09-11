<?php

namespace App\Repository\Admin;

use App\Models\Admin\Admin;

readonly class UserRepository
{
    /**
     * @param Admin $model
     */
    public function __construct(
        public Admin $model,
    ) {}

    /**
     * @param string $username
     * @return Admin|null
     */
    public function findByUsername(string $username): ?Admin
    {
        return $this->model->whereUsername($username)->first();
    }
}
