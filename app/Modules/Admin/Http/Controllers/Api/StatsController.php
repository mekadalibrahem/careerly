<?php

namespace App\Modules\Admin\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Modules\Admin\Services\StatsServices;

class StatsController extends ApiController
{


    public function index()
    {
        try {
            return $this->respondWithSuccess(StatsServices::getAllStat());
        } catch (\Throwable $th) {
            return $this->respondError("ERROR  " .  $th->getMessage());
        }
    }
}
