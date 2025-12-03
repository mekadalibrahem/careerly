<?php

namespace App\Modules\Admin\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Modules\Admin\Services\StatsServices;

class StatsController extends ApiController
{


    public function index()
    {
        try {

            $totalUser = StatsServices::getUserCount();
            $userGrobByRole = StatsServices::getUserCountByRole();
            $totalJob = StatsServices::getJobCount();
            $totlaApplicants = StatsServices::getApplicationCount();
            $totalJobByType = StatsServices::getJobCountByType();
            $countRecentRegistrations = StatsServices::getUserResentRegisteration();
            return $this->respondWithSuccess([

                "total_users" => $totalUser,
                "total_jobs" =>  $totalJob,
                "total_applications" => $totlaApplicants,
                "users_by_role" => $userGrobByRole,
                "jobs_by_type" => $totalJobByType,
                "recent_registrations" => $countRecentRegistrations

            ]);
        } catch (\Throwable $th) {
            return $this->respondError("ERROR  " .  $th->getMessage());
        }
    }
}
