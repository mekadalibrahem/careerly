<?php

use App\Models\User;
use App\Models\Work;
use App\Notifications\AcceptOnWork;
use Illuminate\Support\Facades\Route;


Route::view('/', 'start');

Route::get("/test",  function () {
    $user = User::first();
    $work = Work::first();
    $user->notify(new AcceptOnWork($work->id, $work->name));
});
