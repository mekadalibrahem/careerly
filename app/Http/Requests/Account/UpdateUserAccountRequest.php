<?php

namespace App\Http\Requests\Account;

use App\Models\User;
use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        $targetUser = User::find($this->route('id'));


        if (!$user || !$targetUser) {
            return false;
        }


        return $user->can('update', $targetUser);
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
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('id'),
            'title' => 'required|string',
        ];
    }
}
