<?php


namespace App\Modules\N8n\Http\Requests;

use App\Modules\Users\Enums\UserRolesEnums;
use App\Utils\PermissionsKeyEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserCvAnalyzeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $userAuthed = Auth::user();
        $user = $this->route('user');
        // return dd($user);
        if ($userAuthed && $user && $user->id == $userAuthed->id && $userAuthed->hasPermissionTo(PermissionsKeyEnum::MANAGE_PROFILE())) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }
}
