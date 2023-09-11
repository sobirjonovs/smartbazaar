<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Dto\Merchant\LoginDto;
use App\Dto\Merchant\MerchantDto;
use App\Dto\Merchant\RegistrationDto;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\LoginRequest;
use App\Http\Requests\Merchant\RegisterRequest;
use App\Http\Requests\Merchant\UpdateRequest;
use App\Http\Resources\Merchant\MeResource;
use App\Services\Merchant\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        public AuthService $service
    ) {}

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws UnauthorizedException
     * @throws NotFoundException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->service->login(new LoginDto(
            email: $request->get('email'),
            password: $request->get('password')
        ));

        return response()->success($result);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->service->register(new RegistrationDto(
            name: $request->get('name'),
            description: $request->get('description'),
            email: $request->get('email'),
            password: $request->get('password')
        ));

        return response()->success($result);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function me(Request $request): mixed
    {
        return response()->success(new MeResource($request->user('api-merchant')));
    }

    /**
     * @param UpdateRequest $request
     * @return mixed
     * @throws NotFoundException
     */
    public function update(UpdateRequest $request)
    {
        $merchant = $this->service->update(new MerchantDto(
            name: $request->get('name'),
            description: $request->get('description'),
            email: $request->user('api-merchant')->email,
            id: $request->user('api-merchant')->getKey()
        ));

        return response()->success($merchant);
    }
}
