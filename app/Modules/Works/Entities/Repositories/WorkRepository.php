<?php

namespace App\Modules\Works\Entities\Repositories;

use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Enums\WorkStatusEnum;

class WorkRepository
{


    public static function active_work(Work $model): bool
    {
        try {
            $model->status = WorkStatusEnum::ACTIVE();
            return $model->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function close_work(Work $model): bool
    {
        $model->status = WorkStatusEnum::CLOSED();
        return $model->save();
    }
    public static function isActive(Work $model)
    {
        return ($model->status == WorkStatusEnum::ACTIVE()) ? true : false;
    }
}
