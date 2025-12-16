<?php

namespace App\Modules\Exports\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Modules\Exports\Enums\CvStyleTypesEnum;

class CvStylesController extends ApiController
{

    public  function index()
    {
        return $this->respondWithSuccess([
            'styles' => CvStyleTypesEnum::values(),
        ]);
    }
}
