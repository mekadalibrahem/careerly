<?php

namespace App\Modules\Exports\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Jobs\RenderCvFIleJob;
use App\Models\User;
use App\Modules\Exports\Entities\Download;
use App\Modules\Exports\Http\Requests\DownloadFileRequest;
use App\Modules\Exports\Http\Requests\StoreFileRequest;
use Illuminate\Support\Facades\Storage;

class DownloadManagerController extends  ApiController
{

    public function store(StoreFileRequest $request , User $user)
    {
        try {
            $validated = $request->validated();
            // call job to render cv
            RenderCvFIleJob::dispatch($user->id, $validated);
            return  $this->respondOk("Your Request sent will send notification when file is ready");
        }catch (\Throwable $th){
            return $this->respondError($th->getMessage());
        }

    }
    public function download(DownloadFileRequest $request , User $user, Download $download)
    {
        try {
            $validated = $request->validated();
//            return dd($download->isExpired());
            if( $download->isExpired() || !Storage::disk("temp")->exists($download->path)){
                return  $this->respondError("file not found or expired");
            }
            $filename = $download->path;
            return response()->streamDownload(
                function () use ($download) {
                    $stream = Storage::disk('temp')->readStream($download->path);
                    fpassthru($stream);
                    if (is_resource($stream)) {
                        fclose($stream);
                    }
                },
                $filename,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                ]
            );


        }catch (\Throwable $th){
            return $this->respondError($th->getMessage());
        }
    }
}
