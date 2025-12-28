<?php

namespace App\Modules\Works\Http\Requests;

use App\Modules\Works\Entities\Models\WorkRequirement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreWorkRequirementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $work = $this->route('work');
        return $user->can("create", $work, WorkRequirement::class);
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
            "description" => 'nullable|string',
            "level" => "required|string|max:255",
        ];
    }
}
