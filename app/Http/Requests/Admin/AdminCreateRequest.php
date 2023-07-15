<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Base\BaseRequest;

class AdminCreateRequest extends BaseRequest
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
            'password' => 'required|min:6|max:20',
            'avatar' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
