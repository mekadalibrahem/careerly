<?php

namespace App\Modules\Works\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Entities\Repositories\WorkRepository;
use App\Modules\Works\Enums\WorkStatusEnum;
use Illuminate\Support\Facades\Auth;

class WorkStatusController extends ApiController
{


    private function validate(Work $work): bool
    {
        $user = Auth::user();
        return $user->can('update', $work);
    }
    public function activate(Work $work)
    {

        try {
            if ($this->validate($work)) {

                if (WorkRepository::active_work($work)) {

                    return $this->respondOk("work activate");
                } else {
                    return $this->respondError("FAILD ACTIVE ITEM");
                }
            } else {
                return $this->respondForbidden();
            }
        } catch (\Throwable $th) {
            return $this->respondError("FAILD  ACTIVEATE   ITEM " . $th->getMessage());
        }
    }

    public function close(Work $work)
    {
        try {
            if ($this->validate($work)) {

                if (WorkRepository::close_work($work)) {

                    return $this->respondOk("work colsed");
                } else {
                    return $this->respondError("FAILD ClOSE ITEM");
                }
            } else {
                return $this->respondForbidden();
            }
        } catch (\Throwable $th) {
            return $this->respondError("FAILD  CLOSE   ITEM " . $th->getMessage());
        }
    }
}
