<?php


namespace App\Modules\N8n\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ApplicantRateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $userAuthedOwnedWork = Auth::user();
        $work = $this->route('work');

        if ($userAuthedOwnedWork && $work && $work->user_id == $userAuthedOwnedWork->id) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'applicants_ids' => ['nullable', 'array'],
            'applicants_ids.*' => [
                'integer',
                'min:1',
            ],
        ];
    }
}
