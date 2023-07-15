<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Frontend\UserAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function __construct(private readonly UserAuthService $service)
    {
    }

    public function me(): JsonResponse
    {
        return response()->json([
            'success' => true,
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return ApiResponse($this->service->login($request));
    }

    public function logout(Request $request): JsonResponse
    {
        return ApiResponse($this->service->logout($request));
    }

    public function profile(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'profile' => $request->user(),
        ]);
    }
}
