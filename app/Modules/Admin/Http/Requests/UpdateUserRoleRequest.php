<?php


namespace App\Modules\Admin\Http\Requests;

use App\Modules\Users\Enums\UserRolesEnums;
use App\Modules\Works\Entities\Models\Applicant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $updatedUser = $this->route('user');
        if (!$user || !$updatedUser) {
            return false;
        }
        if (!$user->role == UserRolesEnums::ADMIN()) {
            return false;
        }
        return $user->can("update", $updatedUser);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "role" => ['required', 'string', Rule::enum(UserRolesEnums::class)],
        ];
    }
}
