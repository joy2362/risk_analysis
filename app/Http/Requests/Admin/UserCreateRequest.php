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
            'avatar' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',

            'no_of_child' => 'required',
            'children_profession' => 'nullable',

            'other_member_have_bank_account' => 'required',
            'other_earning_member' => 'required',

            'own_house' => 'required',
            'total_land' => 'required',
            'house_made_of' => 'required',

            'parent_is_alive' => 'required',
            'parent_available' => 'nullable',
            'parent_profession' => 'nullable',

            'spouse_name' => 'nullable',
            'spouse_is_alive' => 'required',
            'spouse_dob' => 'nullable|date',
            'spouse_nid_number' => 'nullable',
            'spouse_education' => 'nullable',
            'spouse_profession' => 'nullable',
            'spouse_income' => 'nullable',
        ];
    }
}
