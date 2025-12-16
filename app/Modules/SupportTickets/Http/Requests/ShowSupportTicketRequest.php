<?php

namespace App\Modules\SupportTickets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShowSupportTicketRequest extends FormRequest
{
    public function rules(): array
    {
        return [

        ];
    }

    public function authorize(): bool
    {
        $authedUser = Auth::user();
        $ticket = $this->route("supportTicket");
        return ($ticket && $ticket->user_id == $authedUser->id);

    }
}
