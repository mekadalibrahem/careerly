<?php

namespace App\Modules\Admin\Http\Requests\SupportTicket;

use App\Modules\Users\Enums\UserRolesEnums;
use App\Utils\PermissionsKeyEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShowAdminSupportTicketRequest extends FormRequest
{
    public function rules(): array
    {
        return [

        ];
    }

    public function authorize(): bool
    {
        $authedUser = Auth::user();

        return ($authedUser && $authedUser->hasPermissionTo(PermissionsKeyEnum::MANAGE_USER())) ;
    }
}
