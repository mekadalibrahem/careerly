<?php

namespace App\Http\Requests\Qaulifications;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEducationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $education = $this->route('education');
        if (!$user || !$education) {
            return false;
        }

        return $user->can("update", $education);
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
            "institution" => 'required|string|max:255',
            "degree" => 'required|string|max:255',
             "grade" => 'required|numeric|min:50.00|max:100|decimal:1,3',
            "start_at" => 'required|date',
            "end_at" => 'nullable|date',
        ];
    }
}
