<?php

use App\Models\User;
use App\Models\Work;
use App\Modules\Qualifications\Entities\Models\Skill;
use App\Notifications\AcceptOnWork;
use Illuminate\Support\Facades\Route;


Route::view('/', 'start');

Route::get("/test",  function () {
    return dd($usersId = User::where("id" , '>' , 1)->pluck('id')->toArray());
});
