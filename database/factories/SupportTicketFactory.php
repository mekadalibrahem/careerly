<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\SupportTickets\Enums\SupportTicketsPriorities;
use App\Modules\SupportTickets\Enums\SupportTicketsStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\SupportTickets\Entities\SupportTicket>
 */
class SupportTicketFactory extends Factory
{
    public function definition(): array
    {
        $usersId =$usersId = User::where("id" , '>' , 1)->pluck('id')->toArray();
        return [
            "message" => fake()->text(),
            "subject"=> fake()->words(3,true),
            "priority" =>fake()->randomElement(SupportTicketsPriorities::values()),
            "status" => fake()->randomElement(SupportTicketsStatus::values()),
            "note" => fake()->words(10, true),
            "user_id" => fake()->randomElement($usersId)
        ];
    }
}
