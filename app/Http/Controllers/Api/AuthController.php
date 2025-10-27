<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Modules\Users\Enums\UserRolesEnums;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return $this->respondError('Invalid credentials');
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->respondWithSuccess([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function register(CreateUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'title' => $validated['title'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;
        return $this->respondCreated([
            'user' => $user,
            'token' => $token,
        ]);
    }
}
