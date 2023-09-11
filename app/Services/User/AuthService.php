<?php

namespace App\Services\User;

use App\Dto\User\CreateUserDto;
use App\Dto\User\LoginDto;
use App\Dto\User\RegistrationDto;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Repository\User\UserRepository;
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
     * @param RegistrationDto $dto
     * @return array
     */
    public function register(RegistrationDto $dto): array
    {
        $password = Hash::make($dto->password);

        $user = $this->repository->create(new CreateUserDto(
            name: $dto->name,
            email: $dto->email,
            password: $password
        ));

        return [
            'access_token' => $user->createToken('user')->accessToken,
            'user' => $user->toArray()
        ];
    }

    /**
     * @throws UnauthorizedException|NotFoundException
     */
    public function login(LoginDto $dto): array
    {
        $user = $this->repository->findByEmail($dto->email);

        if (null === $user) {
            throw new NotFoundException('User not found');
        }

        if (! Hash::check($dto->password, $user->getAuthPassword())) {
            throw new UnauthorizedException('Unauthorized');
        }

        return [
            'access_token' => $user->createToken('user')->accessToken
        ];
    }
}
