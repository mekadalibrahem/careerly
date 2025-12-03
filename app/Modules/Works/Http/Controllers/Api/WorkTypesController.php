<?php

namespace App\Modules\Works\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Modules\Works\Enums\WorkTypesEnum;

class WorkTypesController extends ApiController
{



    public function index()
    {
        try {
         
            return $this->respondWithSuccess([
                "types" => WorkTypesEnum::values()
            ]);
        } catch (\Throwable $th) {
            $this->respondError("FAILD  RETURN WORK TYPES VALUES" . $th->getMessage());
        }
    }
}
