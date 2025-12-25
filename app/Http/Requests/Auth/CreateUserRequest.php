<?php

namespace App\Http\Requests\Auth;

use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => ['required', 'string', Rule::enum(UserRolesEnums::class)->except([UserRolesEnums::SUPER_ADMIN, UserRolesEnums::ADMIN])],
            'password' => 'required|string|min:8|confirmed',
            'title' => 'nullable|string|max:255',
            "bio" => "nullable|string|max:2500",
            "phone" => "nullable|string|max:15",
            "company" => "nullable|string|max:255"
        ];
    }
}
