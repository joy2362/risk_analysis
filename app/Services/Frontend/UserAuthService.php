<?php

namespace App\Services\Frontend;

use App\Models\Users\User;
use App\Traits\Backend\ServiceReturnCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserAuthService
{
    use ServiceReturnCollection;

    private Collection $collection;

    /**
     * @param $request
     * @return Collection
     */
    public function login($request): Collection
    {
        return Auth::guard('web')->attempt($request->validated()) ? $this->success(
            [
                'message' => trans('auth.success'),
                'token' => $this->generateAuthToken($request->input('email')),
            ]
        ) : $this->failed(['error' => trans('auth.failed')]);
    }

    /**
     * @param $email
     * @return mixed
     */
    private function generateAuthToken($email): mixed
    {
        $user = User::where('email', $email)->first();
        return $user->createToken('token', ['role:user'])->plainTextToken;
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function logout(Request $request): Collection
    {
        return $request->user()->currentAccessToken()->delete() ?
            $this->success(['message' => trans('auth.logout')])
            : $this->failed(['error' => trans('auth.Unauthenticated')]);
    }

}
