<?php
namespace App\Modules\Exports\Http\Requests;


use App\Modules\Exports\Entities\Download;
use App\Modules\Exports\Enums\CvStyleTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreFileRequest extends  FormRequest {
    /**
     * Determine if the user is authorized to this request
     */
    public  function authorize():bool
    {
        $authedUser = Auth::user();
        $requestedUser = $this->route('user');
        if(!$authedUser || !$requestedUser){
            return  false;
        }
        if($authedUser->id !== $requestedUser->id){
            return false;
        }
        if($authedUser->can('create', Download::class)){
            return true;
        }
        return  false;
    }

    /**
     * Get validation rules that apply to the request
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public  function  rules():array
    {
        return [
            "type" => ['required' , Rule::enum(CvStyleTypesEnum::class)],
            "lang" => "nullable|string",
            "title" => "nullable|string",
            'bio' => "nullable|string",
            'project_ids' => ['nullable', 'array'],
            'project_ids.*' => [
                'integer',
                'min:1',
            ],
            'skill_ids' => ['nullable', 'array'],
            'skill_ids.*' => [
                'integer',
                'min:1',
            ],
            'course_ids' => ['nullable', 'array'],
            'course_ids.*' => [
                'integer',
                'min:1',
            ],
            'education_ids' => ['nullable', 'array'],
            'education_ids.*' => [
                'integer',
                'min:1',
            ],
        ];
    }
}
