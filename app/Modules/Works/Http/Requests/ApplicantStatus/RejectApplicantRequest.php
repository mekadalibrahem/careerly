<?php


namespace App\Modules\Works\Http\Requests\ApplicantStatus;


use App\Modules\Works\Enums\ApplicantStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RejectApplicantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $work = $this->route('work');
        $applicant = $this->route('applicant');
        if($user->can('reject' , $applicant, $work)){
            return  true;
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
