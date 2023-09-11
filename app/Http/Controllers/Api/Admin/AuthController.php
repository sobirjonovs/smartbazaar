<?php

namespace App\Http\Controllers\Api\Admin;

use App\Dto\Admin\LoginDto;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        public AuthService $service
    ) {}

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws UnauthorizedException|NotFoundException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->service->login(new LoginDto(
            username: $request->get('username'),
            password: $request->get('password')
        ));

        return response()->success($result);
    }
}
