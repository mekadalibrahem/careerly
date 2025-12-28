<?php


namespace App\Modules\Admin\Http\Requests;

use App\Utils\PermissionsKeyEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminDeleteUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $deleteUser = $this->route('user');
        if (!$user || !$deleteUser) {
            return false;
        }
        if (!$user->hasPermissionTo(PermissionsKeyEnum::MANAGE_USER())) {
            return false;
        }
        return $user->can("delete", $deleteUser);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

        ];
    }
}
