<?php

namespace App\Services\Merchant;

use App\Dto\Merchant\CreateUserDto;
use App\Dto\Merchant\LoginDto;
use App\Dto\Merchant\MerchantDto;
use App\Dto\Merchant\RegistrationDto;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Models\Merchant\Merchant;
use App\Repository\Merchant\UserRepository;
use Illuminate\Http\Request;
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

        $user = $this->repository->createOrUpdate(new CreateUserDto(
            name: $dto->name,
            description: $dto->description,
            email: $dto->email,
            password: $password,
            id: $dto->id
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
        $user = $this->fetchUser($dto->email);

        if (!Hash::check($dto->password, $user->getAuthPassword())) {
            throw new UnauthorizedException('Unauthorized');
        }

        return [
            'access_token' => $user->createToken('merchant')->accessToken
        ];
    }

    /**
     * @param MerchantDto $dto
     * @return Merchant
     * @throws NotFoundException
     */
    public function update(MerchantDto $dto): Merchant
    {
        $user = $this->fetchUser($dto->email);

        $this->repository->createOrUpdate(new CreateUserDto(
            name: $dto->name,
            description: $dto->description,
            email: $user->email,
            password: $user->getAuthPassword(),
            id: $user->getKey()
        ));

        return $user;
    }

    /**
     * @param string $email
     * @return Merchant
     * @throws NotFoundException
     */
    public function fetchUser(string $email): Merchant
    {
        $user = $this->repository->findByEmail($email);

        if (null === $user) {
            throw new NotFoundException('Merchant not found');
        }

        return $user;
    }
}
