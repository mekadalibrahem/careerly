<?php
namespace  App\Modules\Exports;

use App\Modules\Exports\Contracts\ExportStrategy;

class  ExportManager
{
    private ExportStrategy $exportStrategy;
    public function __construct(ExportStrategy $exportStrategy)
    {
        $this->exportStrategy = $exportStrategy;
    }
    public function exprot($data , $saveAsFileName)
    {
        $this->exportStrategy->render($data,$saveAsFileName);
    }
}
