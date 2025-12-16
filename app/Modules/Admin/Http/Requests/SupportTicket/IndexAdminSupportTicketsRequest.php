<?php

namespace App\Modules\Admin\Http\Requests\SupportTicket;

use App\Modules\SupportTickets\Enums\SupportTicketsPriorities;
use App\Modules\SupportTickets\Enums\SupportTicketsStatus;
use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class IndexAdminSupportTicketsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "priorities" => ["nullable" , "array"],
            "priorities.*" => ["string" , Rule::enum(SupportTicketsPriorities::class)],
            "status" => ["nullable" , "array"],
            "status.*" => ['string' , Rule::enum(SupportTicketsStatus::class)],
            "searchString" => ["nullable"  , "string"]
        ];
    }

    public function authorize(): bool
    {
        $authedUser = Auth::user();

        return ($authedUser && $authedUser->role == UserRolesEnums::ADMIN()) ;
    }
}
