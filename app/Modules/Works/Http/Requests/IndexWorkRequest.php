<?php

namespace App\Modules\Works\Http\Requests;

use App\Modules\Works\Enums\WorkStatusEnum;
use App\Modules\Works\Enums\WorkTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class IndexWorkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "searchString" => ["nullable"  , "string"],
            'type' => ["nullable", "array"],
            "type.*" => ["string", Rule::enum(WorkTypesEnum::class)],
            "status" =>  ["nullable", "string", Rule::enum(WorkStatusEnum::class)],
            "recruiter_id" => ['nullable' , 'int']
        ];
    }
}
