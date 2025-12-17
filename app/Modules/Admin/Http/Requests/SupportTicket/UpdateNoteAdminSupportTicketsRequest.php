<?php

namespace App\Modules\Admin\Http\Requests\SupportTicket;

use App\Modules\SupportTickets\Enums\SupportTicketsPriorities;
use App\Modules\SupportTickets\Enums\SupportTicketsStatus;
use App\Modules\Users\Enums\UserRolesEnums;
use App\Utils\PermissionsKeyEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateNoteAdminSupportTicketsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "note" => ["required"  , "string"],
            "append" => ['nullable' , 'boolean:']
        ];
    }

    public function authorize(): bool
    {
        $authedUser = Auth::user();

        return ($authedUser && $authedUser->hasPermissionTo(PermissionsKeyEnum::MANAGE_USER())) ;
    }
}
