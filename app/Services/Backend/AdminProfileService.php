<?php

namespace App\Services\Backend;

use App\Models\Users\Admin;
use App\Models\Users\User;
use App\Traits\Backend\ServiceReturnCollection;
use Illuminate\Support\{Collection, Facades\Auth, Facades\Hash};
use Exception;
use Illuminate\Http\Request;

/**
 * handle admin profile related task
 */
class AdminProfileService
{
    use ServiceReturnCollection;

    /**
     * @var Collection
     */
    private Collection $collection;

    /**
     * @param $request
     * @return Collection
     */
    public function updatePassword($request): Collection
    {
        if ($this->matchOldPassword($request->user()->password, $request->input('oldPassword'))) {
            $this->changePassword($request->user()->id, $request->input('newPassword'));
            $this->collection = $this->success(['message' => trans('passwords.reset')]);
        }
        $this->collection = $this->failed(['error' => trans('auth.password')]);
        return $this->collection;
    }

    /**
     * @param $request
     * @return Collection
     */
    public function updateGeneral($request): Collection
    {
        $data = [];
        if (!empty($request->validated()['name'])) {
            $data['name'] = $request->validated()['name'];
        }
        if (!empty($request->validated()['email'])) {
            $data['email'] = $request->validated()['email'];
        }
        $this->collection = $this->updateProfile($request->user()->id, $data)
            ? $this->success(['message' => trans('profile.success')])
            : $this->failed(['error' => trans('profile.failed')]);
        return $this->collection;
    }

    public function changeProfileImage(Request $request): Collection
    {
        try {
            $admin = Admin::find(Auth::id());
            $url = upload($request->file('avatar'), "admin/avatar", $admin->avatar);
            $admin->update([
                'avatar' => $url
            ]);
            $this->collection = $this->success(['message' => trans('profile.avatar')]);
        } catch (Exception $ex) {
            $this->collection = $this->failed(['error' => $ex->getMessage()]);
        }
        return $this->collection;
    }

    public function dashboard(Request $request)
    {
        $totalAdmin = Admin::get()->count();
        $totalUser = User::get()->count();

        $acceptedUser = User::where('status', 'Accept')->get()->count();
        $conditionallyAcceptedUser = User::where('status', 'Conditionally accept')->get()->count();
        $rejectedUser = User::where('status', 'Reject')->get()->count();

        $acceptedUserData = User::where('status', 'Accept')->take(5)->get(['name','score']);
        $conditionallyAcceptedUserData = User::where('status', 'Conditionally accept')->take(5)->get(['name','score']);
        $rejectedUserData = User::where('status', 'Reject')->take(5)->get(['name','score']);

        return $this->success([
            'dashboard' => [
                'totalAdmin' => $totalAdmin ?? 0,
                'totalUser' => $totalUser ?? 0,
                'acceptedUser' => $acceptedUser ?? 0,
                'rejectedUser' => $rejectedUser ?? 0,
                'conditionallyAcceptedUser' => $conditionallyAcceptedUser ?? 0,
                'acceptedUserData' => $acceptedUserData ?? [],
                'conditionallyAcceptedUserData' => $conditionallyAcceptedUserData ?? [],
                'rejectedUserData' => $rejectedUserData ?? [],
            ]
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | class internal methods
    |--------------------------------------------------------------------------
    |
    */

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    private function updateProfile($id, $data): bool
    {
        return Admin::find($id)->update($data);
    }

    /**
     * @param $id
     * @param $password
     * @return void
     */
    private function changePassword($id, $password): void
    {
        Admin::find($id)->update([
            'password' => Hash::make($password)
        ]);
    }

    /**
     * @param $userPassword
     * @param $oldPassword
     * @return bool
     */
    private function matchOldPassword($userPassword, $oldPassword): bool
    {
        return Hash::check($oldPassword, $userPassword);
    }
}
