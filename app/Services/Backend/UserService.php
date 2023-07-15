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
            DB::beginTransaction();
            $userData = $request->only(['name', 'email', 'dob', 'nid_number', 'income', 'profession', 'education', 'gender',]);
            $userData['password'] = Hash::make($request->password);
            if ($request->hasFile('avatar')) {
                $userData['avatar'] = upload($request->avatar, '/user/avatar/');
            }
            $user = User::create($userData);

            if (!empty($request->spouse)) {
                $spouseData = $request->only(['spouse']);
                $spouseData['spouse']['is_alive'] = (boolean)$request->spouse['is_alive'];
                $user->spouse()->create($spouseData['spouse']);
            }

            if (!empty($request->other)) {
                $otherData = $request->only(['other']);
                $otherData['other']['other_earning_member'] = (boolean)$request->other['other_earning_member'];
                $otherData['other']['other_member_have_bank_account'] = (boolean)$request->other['other_member_have_bank_account'];
                $user->other()->create($otherData['other']);
            }

            if (!empty($request->residence)) {
                $residenceData = $request->only(['residence']);
                $residenceData['residence']['own_house'] = (boolean)$request->residence['own_house'];
                $user->residence()->create($residenceData['residence']);
            }

            if (!empty($request->parent)) {
                $parentData = $request->only(['parent']);
                $parentData['parent']['is_alive'] = (boolean)$request->parent['is_alive'];
                $parentData['parent']['available'] = (boolean)$request->parent['available'];
                $user->parent()->create($parentData['parent']);
            }
            if (!empty($request->member)) {
                $memberData = $request->only(['member']);
                $user->member()->create($memberData['member']);
            }
            if (!empty($request->child)) {
                $childData = $request->only(['child']);
                $user->child()->create($childData['child']);
            }
            $this->calculateScore($user);
            DB::commit();
            $this->collection = $this->success(['message' => 'User created']);
        } catch (Exception $ex) {
            DB::rollBack();
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
        $user->load('spouse', 'child', 'parent', 'member', 'other', 'residence');

        $userScore = $this->calculateSpouseScore($user);
        $spouseScore = $user->spouse ? $this->calculateSpouseScore($user->spouse, true) : 0;
        $childScore = $user->child ? $this->calculateChildScore($user->child) : 0;
        $parentScore = $user->parent ? $this->calculateParentScore($user->parent) : 0;
        $memberScore = $user->member ? $this->calculateMemberScore($user->member) : 0;
        $otherScore = $user->other ? $this->calculateOtherScore($user->other) : 0;
        $residenceScore = $user->residence ? $this->calculateResidenceScore($user->residence) : 0;
        $total = $userScore + $spouseScore + $childScore + $parentScore + $memberScore + $otherScore + $residenceScore;
        $user->score = $total;
        $user->update([
            'score' => $total
        ]);
    }

    private function calculateSpouseScore($spouse, $requiredCheckAlive = false): float|int
    {
        $total = 0;

        if ($spouse->income == 0) {
            $total += 3;
        } elseif ($spouse->income > 0 && $spouse->income < 5000) {
            $total += 4;
        } elseif ($spouse->income >= 5000 && $spouse->income < 10000) {
            $total += 5;
        } elseif ($spouse->income >= 10001 && $spouse->income < 20000) {
            $total += 6;
        } elseif ($spouse->income >= 20001 && $spouse->income < 30000) {
            $total += 7;
        } elseif ($spouse->income >= 30001 && $spouse->income < 40000) {
            $total += 8;
        } else {
            $total += 10;
        }

        match ($spouse->profession) {
            UserProfessionEnum::Business->value => $total += 9,
            UserProfessionEnum::RickshawPuller->value => $total += 7,
            UserProfessionEnum::WantedToGoAbroad->value => $total += 3,
            UserProfessionEnum::Unemployed->value, UserProfessionEnum::JobSeeker->value => $total += 5,
            UserProfessionEnum::PrivateJobHolder->value, UserProfessionEnum::Farming->value => $total += 8,
            UserProfessionEnum::GarmentsSector->value, UserProfessionEnum::Driver->value => $total += 6,
            default => $total += 0,
        };

        match ($spouse->education) {
            UserEducationEnum::NoEducation->value, UserEducationEnum::SSCPass->value => $total += 7,
            UserEducationEnum::PassPSC->value => $total += 6,
            UserEducationEnum::PassJSC->value => $total += 5,
            UserEducationEnum::HSCPass->value => $total += 8,
            UserEducationEnum::Graduation->value => $total += 9,
            UserEducationEnum::PostGraduation->value => $total += 10,
            default => $total += 0,
        };

        return ($requiredCheckAlive && !$spouse->is_alive) ? $total / 2 : $total;
    }

    private function calculateChildScore($child): int
    {
        $total = 0;
        match ($child->no_of_child) {
            0, 1 => $total += 5,
            2 => $total += 4,
            3 => $total += 3,
            default => $total += 1,
        };
        if ($child->no_of_child > 0) {
            match ($child->profession) {
                ChildProfessionEnum::AgeLessThan5Years->value => $total += 2,
                ChildProfessionEnum::StudentClass1To5->value => $total += 3,
                ChildProfessionEnum::StudentClass6ToHigh->value, ChildProfessionEnum::JobHolder->value => $total += 5,
                default => $total += 0,
            };
        }
        return $total;
    }

    private function calculateParentScore($parent): float|int
    {
        $total = 0;
        $total += $parent->available ? 10 : 5;

        match ($parent->profession) {
            ParentProfessionEnum::Farming->value => $total += 4,
            ParentProfessionEnum::JobHolder->value => $total += 5,
            ParentProfessionEnum::MoreThan55Years->value => $total += 3,
            default => $total += 0,
        };
        return $parent->is_alive ? $total : $total / 2;
    }

    private function calculateMemberScore($member): int
    {
        $total = 0;
        match ($member->profession) {
            MemberProfessionEnum::HomeMaker->value => $total += 4,
            MemberProfessionEnum::JobHolder->value => $total += 5,
            default => $total += 0,
        };

        if ($member->income == 0) {
            $total += 3;
        } elseif ($member->income > 0 && $member->income < 5000) {
            $total += 4;
        } else {
            $total += 5;
        }

        match ($member->education) {
            UserEducationEnum::NoEducation->value, UserEducationEnum::SSCPass->value, UserEducationEnum::PassPSC->value, UserEducationEnum::PassJSC->value, UserEducationEnum::HSCPass->value => $total += 4,
            UserEducationEnum::Graduation->value, UserEducationEnum::PostGraduation->value => $total += 5,
            default => $total += 0,
        };
        return $total;
    }

    private function calculateOtherScore($other): int
    {
        $total = 0;
        $total += $other->other_earning_member ? 5 : 3;
        $total += $other->other_member_have_bank_account ? 5 : 3;
        return $total;
    }

    private function calculateResidenceScore($residence): int
    {
        $total = 0;
        $total += $residence->own_house ? 5 : 3;
        if ($residence->total_land >= 0 && $residence->total_land <= 4) {
            $total += 3;
        } elseif ($residence->total_land >= 5 && $residence->total_land <= 10) {
            $total += 4;
        } elseif ($residence->total_land >= 11 && $residence->total_land <= 20) {
            $total += 5;
        } elseif ($residence->total_land >= 21 && $residence->total_land <= 40) {
            $total += 6;
        } elseif ($residence->total_land >= 41 && $residence->total_land <= 60) {
            $total += 7;
        } else {
            $total += 9;
        }

        match ($residence->house_made_of) {
            HomeMaterialEnum::OnlyTin->value => $total += 3,
            HomeMaterialEnum::TinAndConcrete->value => $total += 4,
            HomeMaterialEnum::Building->value => $total += 6,
            HomeMaterialEnum::TinAndBamboo->value => $total += 2,
            default => $total += 0,
        };

        return $total;
    }

}
