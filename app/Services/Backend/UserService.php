<?php

namespace App\Services\Backend;

use App\Enums\ChildProfessionEnum;
use App\Enums\HomeMaterialEnum;
use App\Enums\MemberProfessionEnum;
use App\Enums\ParentProfessionEnum;
use App\Enums\UserEducationEnum;
use App\Enums\UserProfessionEnum;
use App\Models\Users\Admin;
use App\Models\Users\User;
use App\Traits\Backend\ServiceReturnCollection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
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
            $users = User::when($request['field'] && $request['search'], function ($q) use ($request) {
                return $q->where($request['field'], 'like', '%' . $request['search'] . '%');
            })->when($request['sortField'] && $request['sortBy'], function ($q) use ($request) {
                return $q->orderBy($request['sortField'], $request['sortBy']);
            })->paginate($request->perPage ?? 10);
            $this->collection = $this->success(['users' => $users]);
        } catch (Exception $ex) {
            $this->collection = $this->failed(['errors' => $ex->getMessage()]);
        }
        return $this->collection;
    }

    public function store(Request $request): Collection
    {
        try {
            $userData = $request->except(['password', 'avatar']);
            $userData['password'] = Hash::make($request->password);

            if ($request->hasFile('avatar')) {
                $userData['avatar'] = upload($request->avatar, '/user/avatar/');
            }

            $userData['parent_is_alive'] = (boolean)$request->parent_is_alive;
            $userData['spouse_is_alive'] = (boolean)$request->spouse_is_alive;
            $userData['other_earning_member'] = (boolean)$request->other_earning_member;
            $userData['other_member_have_bank_account'] = (boolean)$request->other_member_have_bank_account;
            $userData['own_house'] = (boolean)$request->own_house;
            $userData['parent_available'] = (boolean)$request->parent_available;

            $user = User::create($userData);

            $this->calculateScore($user);
            $this->collection = $this->success(['message' => 'User created']);
        } catch (Exception $ex) {
            $this->collection = $this->failed(['errors' => $ex->getMessage()]);
        }

        return $this->collection;
    }

    public function show($id): Collection
    {
        $user = User::find($id);
        return $this->success(['user' => $user ]);
    }

    public function update(Request $request, $id): Collection
    {
        try {
            $userData = $request->except(['password', 'avatar' , '_method']);
         
            if(!empty($request->password)){
                $userData['password'] = Hash::make($request->password);
            }


            if ($request->hasFile('avatar')) {
                $userData['avatar'] = upload($request->avatar, '/user/avatar/');
            }

            $userData['parent_is_alive'] = (boolean)$request->parent_is_alive;
            $userData['spouse_is_alive'] = (boolean)$request->spouse_is_alive;
            $userData['other_earning_member'] = (boolean)$request->other_earning_member;
            $userData['other_member_have_bank_account'] = (boolean)$request->other_member_have_bank_account;
            $userData['own_house'] = (boolean)$request->own_house;
            $userData['parent_available'] = (boolean)$request->parent_available;

            User::where('id',$id)->update($userData);
            $user = User::find($id);
            $this->calculateScore($user);
            $this->collection = $this->success(['message' => 'User updated']);
        } catch (Exception $ex) {
            $this->collection = $this->failed(['errors' => $ex->getMessage()]);
        }

        return $this->collection;
    }

    public function destroy($id): Collection
    {
        try {
            if ($user = User::find($id)) {
                $user->delete();
                $this->collection = $this->success(['message' => 'User Deleted']);
            } else {
                $this->collection = $this->failed(['message' => 'User Not found'], 404);
            }
        } catch (Exception $ex) {
            $this->collection = $this->failed(['errors' => $ex->getMessage()]);
        }

        return $this->collection;
    }

    private function calculateScore($user): void
    {
        $total = $this->calculateUserScore($user) + $this->calculateParentScore($user) + $this->calculateSpouseScore($user) + $this->calculateChildScore($user) + $this->calculateOtherScore($user) + $this->calculateResidenceScore($user);
        if ($total > 69 && $total <= 100) {
            $status = 'Accept';
        } elseif ($total <= 69 && $total >= 50) {
            $status = 'Conditionally accept';
        } else {
            $status = 'Reject';
        }
        $user->update([
            'score' => $total,
            'status' => $status,
        ]);
    }

    private function calculateSpouseScore($user): int
    {
        return $user->spouse_is_alive ? $this->getScoreSpouse($user) : 15;
    }

    private function calculateUserScore($user): int
    {
        $total = 0;
        match ($user->profession) {
            MemberProfessionEnum::HomeMaker->value => $total += 4,
            MemberProfessionEnum::JobHolder->value => $total += 5,
            default => $total += 0,
        };

        if ($user->income == 0) {
            $total += 3;
        } elseif ($user->income > 0 && $user->income < 5000) {
            $total += 4;
        } else {
            $total += 5;
        }

        match ($user->education) {
            UserEducationEnum::NoEducation->value, UserEducationEnum::SSCPass->value, UserEducationEnum::PassPSC->value, UserEducationEnum::PassJSC->value, UserEducationEnum::HSCPass->value => $total += 4,
            UserEducationEnum::Graduation->value, UserEducationEnum::PostGraduation->value => $total += 5,
            default => $total += 0,
        };
        return $total;
    }

    private function getScoreSpouse($user): int
    {
        $total = 0;

        if ($user->spouse_income == 0) {
            $total += 3;
        } elseif ($user->spouse_income > 0 && $user->spouse_income < 5000) {
            $total += 4;
        } elseif ($user->spouse_income >= 5000 && $user->spouse_income < 10000) {
            $total += 5;
        } elseif ($user->spouse_income >= 10001 && $user->spouse_income < 20000) {
            $total += 6;
        } elseif ($user->spouse_income >= 20001 && $user->spouse_income < 30000) {
            $total += 7;
        } elseif ($user->spouse_income >= 30001 && $user->spouse_income < 40000) {
            $total += 8;
        } else {
            $total += 10;
        }

        match ($user->spouse_profession) {
            UserProfessionEnum::Business->value => $total += 9,
            UserProfessionEnum::RickshawPuller->value => $total += 7,
            UserProfessionEnum::WantedToGoAbroad->value => $total += 3,
            UserProfessionEnum::Unemployed->value, UserProfessionEnum::JobSeeker->value => $total += 5,
            UserProfessionEnum::PrivateJobHolder->value, UserProfessionEnum::Farming->value => $total += 8,
            UserProfessionEnum::GarmentsSector->value, UserProfessionEnum::Driver->value => $total += 6,
            default => $total += 0,
        };

        match ($user->spouse_education) {
            UserEducationEnum::NoEducation->value, UserEducationEnum::SSCPass->value => $total += 7,
            UserEducationEnum::PassPSC->value => $total += 6,
            UserEducationEnum::PassJSC->value => $total += 5,
            UserEducationEnum::HSCPass->value => $total += 8,
            UserEducationEnum::Graduation->value => $total += 9,
            UserEducationEnum::PostGraduation->value => $total += 10,
            default => $total += 0,
        };

        return $total;
    }

    private function calculateChildScore($user): int
    {
        return $user->no_of_child == 0 ? 5 : $this->getScoreChild($user);
    }

    private function getScoreChild($user): int
    {
        $total = 0;
        match ($user->no_of_child) {
            1 => $total += 5,
            2 => $total += 4,
            3 => $total += 3,
            default => $total += 1,
        };

        match ($user->children_profession) {
            ChildProfessionEnum::AgeLessThan5Years->value => $total += 2,
            ChildProfessionEnum::StudentClass1To5->value => $total += 3,
            ChildProfessionEnum::StudentClass6ToHigh->value, ChildProfessionEnum::JobHolder->value => $total += 5,
            default => $total += 0,
        };

        return $total;
    }

    private function calculateParentScore($user): float|int
    {
        return $user->parent_is_alive ? $this->getScoreParent($user) : 8;

    }

    private function getScoreParent($user): int
    {
        $total = 0;
        $total += $user->available ? 10 : 5;

        match ($user->profession) {
            ParentProfessionEnum::Farming->value => $total += 4,
            ParentProfessionEnum::JobHolder->value => $total += 5,
            ParentProfessionEnum::MoreThan55Years->value => $total += 3,
            default => $total += 0,
        };
        return $total;
    }

    private function calculateOtherScore($user): int
    {
        $total = 0;
        $total += $user->other_earning_member ? 5 : 3;
        $total += $user->other_member_have_bank_account ? 5 : 3;
        return $total;
    }

    private function calculateResidenceScore($user): int
    {
        $total = 0;
        $total += $user->own_house ? 5 : 3;
        if ($user->total_land >= 0 && $user->total_land <= 4) {
            $total += 3;
        } elseif ($user->total_land >= 5 && $user->total_land <= 10) {
            $total += 4;
        } elseif ($user->total_land >= 11 && $user->total_land <= 20) {
            $total += 5;
        } elseif ($user->total_land >= 21 && $user->total_land <= 40) {
            $total += 6;
        } elseif ($user->total_land >= 41 && $user->total_land <= 60) {
            $total += 7;
        } else {
            $total += 9;
        }

        match ($user->house_made_of) {
            HomeMaterialEnum::OnlyTin->value => $total += 3,
            HomeMaterialEnum::TinAndConcrete->value => $total += 4,
            HomeMaterialEnum::Building->value => $total += 6,
            HomeMaterialEnum::TinAndBamboo->value => $total += 2,
            default => $total += 0,
        };

        return $total;
    }

}
