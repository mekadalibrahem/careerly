<?php


namespace App\Modules\Works\Http\Requests\ApplicantStatus;


use App\Modules\Works\Enums\ApplicantStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SelectApplicantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $work = $this->route('work');
        $applicant = $this->route('applicant');


        return $user->can('select' , $applicant, $work);
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
