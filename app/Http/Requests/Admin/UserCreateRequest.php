<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Base\BaseRequest;

class UserCreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:100',
            'email' => 'required|min:1|max:100|email',
            'nid_number' => 'required|min:1|max:100',
            'password' => 'required|min:6|max:20',
            'dob' => 'required|date',
            'education' => 'required|min:1|max:100',
            'profession' => 'required|min:1|max:100',
            'income' => 'required',
            'gender' => 'required',
            'avatar' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',

            'child.no_of_child' => 'required',
            'child.profession' => 'nullable',

            'member.name' => 'required',
            'member.dob' => 'nullable',
            'member.gender' => 'nullable',
            'member.nid_number' => 'nullable',
            'member.education' => 'required',
            'member.profession' => 'required',
            'member.income' => 'required',

            'other.other_member_have_bank_account' => 'required',
            'other.other_earning_member' => 'required',

            'residence.own_house' => 'required',
            'residence.total_land' => 'required',
            'residence.house_made_of' => 'required',

            'parent.is_alive' => 'required',
            'parent.available' => 'required',
            'parent.profession' => 'required',

            'spouse.name' => 'required',
            'spouse.is_alive' => 'required',
            'spouse.dob' => 'required|date',
            'spouse.nid_number' => 'required',
            'spouse.education' => 'required',
            'spouse.profession' => 'required',
            'spouse.income' => 'required',
            'spouse.gender' => 'required',
        ];
    }
}
