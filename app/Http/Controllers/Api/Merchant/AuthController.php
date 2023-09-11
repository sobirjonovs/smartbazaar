<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Dto\Merchant\LoginDto;
use App\Dto\Merchant\RegistrationDto;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\LoginRequest;
use App\Http\Requests\Merchant\RegisterRequest;
use App\Services\Merchant\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        public AuthService $service
    ) {}

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws UnauthorizedException
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
}
