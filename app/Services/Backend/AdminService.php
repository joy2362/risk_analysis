<?php

namespace App\Services\Backend;

use App\Models\Users\Admin;
use App\Traits\Backend\ServiceReturnCollection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    use ServiceReturnCollection;

    private Collection $collection;

    /**
     * @param $request
     * @return Collection
     */
    public function index($request): Collection
    {
        try {
            $admins = Admin::when($request['field'] && $request['search'], function ($q) use ($request) {
                return $q->where($request['field'], 'like', '%' . $request['search'] . '%');
            })->when($request['sortField'] && $request['sortBy'], function ($q) use ($request) {
                return $q->orderBy($request['sortField'], $request['sortBy']);
            })->paginate($request->perPage ?? 10);
            $this->collection = $this->success(['admins' => $admins]);
        } catch (Exception $ex) {
            $this->collection = $this->failed(['errors' => $ex->getMessage()]);
        }
        return $this->collection;
    }

    public function store(Request $request): Collection
    {
        try {
            $data = $request->except('avatar', 'password');
            $data['password'] = Hash::make($request->password);
            if ($request->hasFile('avatar')) {
                $data['avatar'] = upload($request->avatar, '/admin/avatar/');
            }
            Admin::create($data);

            $this->collection = $this->success(['message' => 'Admin created']);
        } catch (Exception $ex) {
            $this->collection = $this->failed(['errors' => $ex->getMessage()]);
        }

        return $this->collection;
    }

    public function destroy($id): Collection
    {
        try {
            if ($admin = Admin::where('id','<>',auth()->id())->find($id)) {
                $admin->delete();
                $this->collection = $this->success(['message' => 'Admin Deleted']);
            } else {
                $this->collection = $this->failed(['message' => 'Admin Not found'], 404);
            }
        } catch (Exception $ex) {
            $this->collection = $this->failed(['errors' => $ex->getMessage()]);
        }

        return $this->collection;
    }

}
