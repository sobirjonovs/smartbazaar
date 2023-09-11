<?php

namespace App\Http\Controllers\Api\User;

use App\Dto\User\LoginDto;
use App\Dto\User\RegistrationDto;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Services\User\AuthService;
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
            email: $request->get('email'),
            password: $request->get('password')
        ));

        return response()->success($result);
    }
}
