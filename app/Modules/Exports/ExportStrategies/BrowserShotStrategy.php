<?php

namespace App\Modules\Exports\ExportStrategies;

use App\Modules\Exports\Contracts\ExportStrategy;
use App\Modules\Exports\Enums\CvStyleTypesEnum;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Throwable;

class BrowserShotStrategy extends ExportStrategy
{


    public function render($data, $saveAsFileName): bool
    {
        try {

            $browsershot =  Browsershot::html($this->getHtml($data));


            if (!empty(config("export.node_path", ''))) {

                $browsershot->setNodeBinary(config("export.node_path", ''));
            }
            if (!empty(config("export.npm_path", ''))) {

                $browsershot->setNpmBinary(config("export.npm_path", ''));
            }
            $browsershot->format('A4')
                // ->baseUrl(config('app.url'))
                ->waitUntil('domcontentloaded')
                ->timeout(90000);
            // Increase memory limit for Puppeteer
            $browsershot->setExtraExecutionArgs(['--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage', '--memory-pressure-off']);

             $cvPdfFileContent = $browsershot->pdf();
             Storage::disk('temp')->put($saveAsFileName , $cvPdfFileContent);
             return true;
        }catch (Throwable $th){
            throw $th;
        }


    }

    /**
     * @throws Throwable
     */
    private  function  getHtml($data)
    {
        $type = $data['type'];
        if(!CvStyleTypesEnum::validate($type)){
            throw new \RuntimeException("Cv Style [$type] should be on of [" . implode("," , CvStyleTypesEnum::values()) . "]");
        }
        $path = "cv.$type";
        return view($path , $data)->render();
    }

}
