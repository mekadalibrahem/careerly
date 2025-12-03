<?php

namespace App\Modules\Works\Http\Requests;

use App\Modules\Works\Enums\WorkStatusEnum;
use App\Modules\Works\Enums\WorkTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateWorkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $work = $this->route('work');
        if (!$user || !$work) {
            return false;
        }

        return $user->can("update", $work);
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
            "company" => "required|string|max:255",
            "location" => "required|string|max:255",
            'salary_range' => "required|string|max:255",
            'requirements' => "required|string|max:2000",
            'benefits' => "required|string|max:2000",
            'type' => ["required", "string", Rule::enum(WorkTypesEnum::class)],
            "status" =>  ["nullable", "string", Rule::enum(WorkStatusEnum::class)],
        ];
    }
}
