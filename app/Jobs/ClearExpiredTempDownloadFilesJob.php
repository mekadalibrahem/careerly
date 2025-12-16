<?php

namespace App\Jobs;

use App\Modules\Exports\Entities\Download;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ClearExpiredTempDownloadFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(): void
    {
        try{
             $query = Download::query()->valid()
                 ->whereDate('created_at', '<', now()->subDay());
             $files = $query->get();
             foreach ($files as $file){
                 $path = $file->path ;
                 if(Storage::disk('temp')->exists($path)){
                     Storage::disk("temp")->delete($path);
                 }
             }
             $updated = $query->update(['expired_at' => \Carbon\Carbon::now()]);
            logger()->info(__CLASS__ . " Clear Expired files done  file expired count :". $files->count());
        }catch (\Throwable $th){
            logger()->error(__CLASS__ . " " . $th->getMessage());
        }
    }
}
