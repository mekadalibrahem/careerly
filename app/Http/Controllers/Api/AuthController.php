<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
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
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    public function register(CreateUserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],

            'title' => $validated['title'],
            "bio"  => $validated['bio'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);
        $user->assignRole($validated['role']);
        $token = $user->createToken('api-token')->plainTextToken;
        return $this->respondCreated([
            'user' =>new UserResource($user),
            'token' => $token,
        ]);
    }
}
