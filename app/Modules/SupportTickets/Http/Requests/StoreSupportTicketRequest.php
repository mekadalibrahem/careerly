<?php

namespace App\Modules\SupportTickets\Http\Requests;

use App\Modules\SupportTickets\Enums\SupportTicketsPriorities;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreSupportTicketRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "subject"=> "required|string",
            "message"=> "required|string",
            "priority"=> ['required' , Rule::enum(SupportTicketsPriorities::class)]
        ];
    }

    public function authorize(): bool
    {
        $authedUser = Auth::check();

        if($authedUser){
            return true;
        }
        return false;
    }
}
