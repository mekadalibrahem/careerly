<?php

namespace App\Modules\Admin\Http\Requests;

use App\Modules\Users\Enums\UserRolesEnums;
use App\Utils\PermissionsKeyEnum;
use App\Utils\SoftDeletedEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class IndexAdminUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        if (!$user || !$user->hasPermissionTo(PermissionsKeyEnum::MANAGE_USER())) {
            return false;
        }
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
            "role" => ['nullable', 'string', Rule::enum(UserRolesEnums::class)],
            'deleted' => ['nullable','string' , Rule::enum(SoftDeletedEnum::class)],
            'email' => ['nullable' , 'string'],
            "searchString" => "nullable|string",
            'after_created_at' => ['nullable' ,'date' ],
            'before_created_at' => ['nullable' ,'date' ],
            "per_page" => ['nullable' , 'int'],

        ];
    }
}
