<?php

namespace App\Modules\Works\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateWorkRequirementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $work = $this->route('work');
        $workRequirement = $this->route('workRequirement');
        if (!$user || !$work) {
            return false;
        }

        return $user->can("update", $work, $workRequirement);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => 'required|string|max:255',
            "description" => 'required|string',
            "level" => "required|string|max:255"
        ];
    }
}
