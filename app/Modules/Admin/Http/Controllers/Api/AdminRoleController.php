<?php

namespace App\Modules\Admin\Http\Controllers\Api;



use App\Http\Controllers\Api\ApiController;
use App\Modules\Admin\Services\StatsServices;
use Spatie\Permission\Models\Role;

class  AdminRoleController extends ApiController
{
    public  function index()
    {
        try {
                $rolesCount = StatsServices::getAllStat();
                $rolesCount = $rolesCount["users_by_role"];
                $roles= Role::all();

                $data = $roles->map(function ($role) use($rolesCount){
                    return [
                        "name" => $role->name,
                        "description" => $role->description,
                        "permissions" => $role->permissions->pluck('name'),
                        "count" => $rolesCount[$role->name]
                    ];
                });
            return $this->respondWithSuccess([
                "data" =>$data
            ]);
        }catch (\Throwable $th){
            return $this->respondError("ERROR " . $th->getMessage() );
        }
    }
}

