<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Modules\Works\Entities\Dto\WorkUpdatingDto;
use App\Modules\Works\Entities\Models\Work;
use App\Modules\Works\Http\Requests\StoreWorkRequest;
use App\Modules\Works\Http\Requests\UpdateWorkRequest;
use Exception;
use Illuminate\Container\Attributes\DB;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

class UserNotificationController extends ApiController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {


            $notifications = Auth::user()->notifications()->get();
            if ($notifications) {


                return $this->respondWithSuccess([
                    "notifications" => $notifications,
                ]);
            }
            $this->respondNotFound("FAILD ");
        } catch (\Throwable $th) {
            $this->respondError("FAILD   " . $th->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user, $id)
    {
        try {


            $notification  = Auth::user()->notifications()
                // ->select()
                ->where("id", $id)
                ->first();
            if ($notification) {


                return $this->respondWithSuccess([
                    $notification,
                ]);
            }
            $this->respondNotFound("FAILD  NOT FOUND");
        } catch (\Throwable $th) {
            return  $this->respondError("FAILD   " . $th->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, $id)
    {
        try {
            $notification  = Auth::user()->notifications()
                // ->select()
                ->where("id", $id)
                ->first();

            if ($notification) {

                $isDeleted = $notification->delete();

                return $this->respondOk("Item deleted");
            }
            $this->respondNotFound("FAILD ITEM  NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }
    /**
     * Remove the all resource from storage.
     */
    public function destroyAll(User $user)
    {
        try {
            $user->notifications()->delete();

            return $this->respondOk("Items deleted");
        } catch (\Throwable $th) {
            return  $this->respondError("FAILD ITEM DELETED " . $th->getMessage());
        }
    }


    public function markdRead(User $user, $id)
    {
        try {
            $notification  = Auth::user()->notifications()
                // ->select()
                ->where("id", $id)
                ->first();
            if ($notification) {
                $notification->markAsRead();
                return $this->respondOk("done");
            }
            $this->respondNotFound("FAILD ITEM NOT FOUND");
        } catch (\Throwable $th) {
            $this->respondError("FAILD :" . $th->getMessage());
        }
    }
    public function markdReadAll(User $user)
    {
        try {

            Auth::user()->unreadNotifications->markAsRead();
            return $this->respondOk("done");
        } catch (\Throwable $th) {
            $this->respondError("FAILD :" . $th->getMessage());
        }
    }
}
