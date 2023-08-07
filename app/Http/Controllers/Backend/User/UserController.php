<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Models\Users\User;
use App\Services\Backend\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return ApiResponse($this->service->index($request));
    }


    public function store(UserCreateRequest $request): JsonResponse
    {
        return ApiResponse($this->service->store($request));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return ApiResponse($this->service->show($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserCreateRequest $request, string $id): JsonResponse
    {
        return ApiResponse($this->service->update($request, $id));
    }


    public function destroy($id): JsonResponse
    {
        return ApiResponse($this->service->destroy($id));
    }
}
