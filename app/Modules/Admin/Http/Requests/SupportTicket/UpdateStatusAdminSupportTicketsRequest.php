<?php

namespace App\Modules\Admin\Http\Requests\SupportTicket;

use App\Modules\SupportTickets\Enums\SupportTicketsPriorities;
use App\Modules\SupportTickets\Enums\SupportTicketsStatus;
use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateStatusAdminSupportTicketsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "status" => ['string' , Rule::enum(SupportTicketsStatus::class)],
            "note" => ["nullable"  , "string"],
            "append" => ['nullable' , 'boolean:']
        ];
    }

    public function authorize(): bool
    {
        $authedUser = Auth::user();

        return ($authedUser && $authedUser->role == UserRolesEnums::ADMIN()) ;
    }
}
