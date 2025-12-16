<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\SupportTickets\Entities\SupportTicket;
use App\Modules\SupportTickets\Enums\SupportTicketsPriorities;
use App\Modules\SupportTickets\Enums\SupportTicketsStatus;
use Illuminate\Database\Seeder;

class SupportTicketsSeeder extends Seeder
{
    public function run(): void
    {
        $usersId = User::where("id" , '>' , 1)->pluck('id')->toArray();
       for ($i=1 ; $i<=100 ; $i++){
           SupportTicket::create([
               "message" => fake()->text(),
               "subject"=> fake()->words(3,true),
               "priority" =>fake()->randomElement(SupportTicketsPriorities::values()),
               "status" => fake()->randomElement(SupportTicketsStatus::values()),
               "note" => fake()->words(10, true),
               "user_id" => fake()->randomElement($usersId)
           ]);
       }
    }
}
