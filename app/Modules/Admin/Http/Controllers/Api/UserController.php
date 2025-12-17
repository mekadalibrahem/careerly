<?php

namespace App\Modules\Admin\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Modules\Admin\Http\Requests\IndexAdminUsersRequest;
use App\Modules\Admin\Http\Requests\UpdateUserRoleRequest;
use App\Modules\Admin\Http\Resources\AdminUserResource;
use App\Modules\Admin\Services\UserManagmentService;
use Illuminate\Http\Request;

class UserController extends ApiController
{



    public function index(IndexAdminUsersRequest $request)
    {

        try {
            $validated = $request->validated();


            return UserManagmentService::getAllUser($validated) ;
        } catch (\Throwable $th) {
            return $this->respondError("ERROR  " .  $th->getMessage());
        }
    }

    public function show(User $user)
    {

        try {
            if (!$user) {
                return $this->respondNotFound("NOT FOUND ITEM");
            }
            return $this->respondWithSuccess([
                "user" => new AdminUserResource($user)
            ]);
        } catch (\Throwable $th) {
            return $this->respondError("ERROR " .  $th->getMessage());
        }
    }

    public function ban(User $user)
    {

        try {
            if (!$user) {
                return $this->respondNotFound("NOT FOUND ITEM");
            }
            if (UserManagmentService::banUser($user)) {

                return $this->respondOk("User banded");
            } else {
                return $this->respondError("FAILD TO BAN USER");
            }
        } catch (\Throwable $th) {
            return $this->respondError("ERROR  " .  $th->getMessage());
        }
    }
    public function unban(User $user)
    {

        try {
            if (!$user) {
                return $this->respondNotFound("NOT FOUND ITEM");
            }
            if (UserManagmentService::unbanUser($user)) {

                return $this->respondOk("User unbaned");
            } else {
                return $this->respondError("FAILD TO UNBAN USER");
            }
        } catch (\Throwable $th) {
            return $this->respondError("ERROR  " .  $th->getMessage());
        }
    }
    public function delete(User $user)
    {

        try {
            if (!$user) {
                return $this->respondNotFound("NOT FOUND ITEM");
            }
            if (UserManagmentService::deleteUser($user)) {

                return $this->respondOk("User deleted");
            } else {
                return $this->respondError("FAILD TO DELETE USER");
            }
        } catch (\Throwable $th) {
            return $this->respondError("ERROR  " .  $th->getMessage());
        }
    }
    public function role(UpdateUserRoleRequest $request, User $user)
    {

        try {
            $validate = $request->validated();
            if (!$user) {
                return $this->respondNotFound("NOT FOUND ITEM");
            }
            if (UserManagmentService::roleUser($user, $validate['role'])) {

                return $this->respondOk("User role updared");
            } else {
                return $this->respondError("FAILD TO UPDATE USER ROLE");
            }
        } catch (\Throwable $th) {
            return $this->respondError("ERROR  " .  $th->getMessage());
        }
    }
}
