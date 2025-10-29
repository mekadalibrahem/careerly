<?php

namespace App\Http\Requests\Work;

use App\Models\Work;
use App\Models\WorkRequirment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreWorkRequirmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $work = $this->route('work');
        return $user->can("create", $work, WorkRequirment::class);
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
            "level" => "required|string|max:255",
        ];
    }
}
