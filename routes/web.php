<?php

use App\Models\User;
use App\Models\Work;
use App\Notifications\AcceptOnWork;
use Illuminate\Support\Facades\Route;


Route::view('/', 'start');

Route::get("/test",  function () {
    $user = User::where('id', 3)->with(['skills', 'projects', 'courses', 'educations'])->first();
    return $user;
});
