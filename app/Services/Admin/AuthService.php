<?php

namespace App\Services\Admin;

use App\Dto\Admin\LoginDto;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Repository\Admin\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @param UserRepository $repository
     */
    public function __construct(
        public UserRepository $repository,
    ) {}

    /**
     * @throws UnauthorizedException
     * @throws NotFoundException
     */
    public function login(LoginDto $dto): array
    {
        $user = $this->repository->findByUsername($dto->username);

        if (null === $user) {
            throw new NotFoundException('Admin not found');
        }

        if (!Hash::check($dto->password, $user->getAuthPassword())) {
            throw new UnauthorizedException('Unauthorized');
        }

        return [
            'access_token' => $user->createToken('admin')->accessToken
        ];
    }
}
