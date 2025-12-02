<?php

namespace App\Modules\Qualifications\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $course = $this->route('course');
        if (!$user || !$course) {
            return false;
        }

        return $user->can("update", $course);
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
            "provider" => 'required|string|max:255',
            "duration" => 'required|string|max:255',
            "url" => 'nullable|url|max:255',
        ];
    }
}
