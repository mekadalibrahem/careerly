<?php


namespace App\Modules\N8n\Http\Requests;


use App\Utils\PermissionsKeyEnum;
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

        return $userAuthedOwnedWork &&
            $work &&
            $work->user->is($userAuthedOwnedWork->id) &&
            $userAuthedOwnedWork->hasPermissionTo(PermissionsKeyEnum::AI_REQUEST_ANALYZE_APPLICANT());
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
