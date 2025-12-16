<?php

namespace  App\Modules\Exports\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class  DownloadFileRequest extends  FormRequest
{

    public function authorize():bool
    {
        $authedUser = Auth::user();
        $fileUserOwner = $this->route('user');
        $fileWillDownload = $this->route("download");
        return $authedUser && $fileUserOwner && $fileWillDownload && $authedUser->id === $fileUserOwner->id && $authedUser->can('view', $fileWillDownload);

    }

    public function rules():array
    {
        return [];
    }
}


