<?php


namespace App\Modules\Works\Http\Requests\ApplicantStatus;


use App\Modules\Works\Enums\ApplicantStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AcceptApplicantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authedUser = Auth::user();
        $applicantUser = $this->route('user');
        $applicant = $this->route('applicant');
        if ($applicantUser->id == $authedUser->id && $applicant->user_id == $authedUser->id) {
            if ($applicant->status == ApplicantStatusEnum::PENDING()) {
                return true;
            }
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
        return [];
    }
}
