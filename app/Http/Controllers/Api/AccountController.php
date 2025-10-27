<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Account\UpdatePasswordRequest;
use App\Http\Requests\Account\UpdateUserAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends ApiController
{

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();
        if (!$user || !Hash::check($validated['old_password'], $user->password)) {
            return $this->respondError('Invalid credentials');
        }
        $user->password = Hash::make($validated['password']);
        if ($user->save()) {
            return $this->respondWithSuccess(["message" => "password updated"]);
        } else {
            return $this->respondError("UnKnown Error");
        }
    }
    public function updateAccount(UpdateUserAccountRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->title = $validated['title'];
        if ($user->save()) {
            return $this->respondWithSuccess(["message" => "Account updated"]);
        } else {
            return $this->respondError("UnKnown Error");
        }
    }
}
