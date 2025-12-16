<?php

namespace App\Modules\Exports\Contracts;


use Throwable;

abstract class  ExportStrategy
{
    /**
     * @throws Throwable
     */
    abstract public function  render($data, $saveAsFileName):bool;

}
