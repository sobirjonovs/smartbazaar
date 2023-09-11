<?php

namespace App\Services\Merchant;

use App\Dto\Merchant\CreateUserDto;
use App\Dto\Merchant\LoginDto;
use App\Dto\Merchant\RegistrationDto;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Repository\Merchant\UserRepository;
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
            description: $dto->description,
            email: $dto->email,
            password: $password
        ));

        return [
            'access_token' => $user->createToken('merchant')->accessToken,
            'user' => $user->toArray()
        ];
    }

    /**
     * @throws UnauthorizedException
     * @throws NotFoundException
     */
    public function login(LoginDto $dto): array
    {
        $user = $this->repository->findByEmail($dto->email);

        if (null === $user) {
            throw new NotFoundException('Merchant not found');
        }

        if (!Hash::check($dto->password, $user->getAuthPassword())) {
            throw new UnauthorizedException('Unauthorized');
        }

        return [
            'access_token' => $user->createToken('merchant')->accessToken
        ];
    }
}
