<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCreateRequest;
use App\Services\Backend\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(private readonly AdminService $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return ApiResponse($this->service->index($request));
    }

    public function store(AdminCreateRequest $request): JsonResponse
    {
        return ApiResponse($this->service->store($request));
    }

    public function destroy($id): JsonResponse
    {
        return ApiResponse($this->service->destroy($id));
    }
}
