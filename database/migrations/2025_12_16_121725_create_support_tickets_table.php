<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string("subject");
            $table->text("message");
            $table->enum('priority' , \App\Modules\SupportTickets\Enums\SupportTicketsPriorities::values());
            $table->enum("status" , \App\Modules\SupportTickets\Enums\SupportTicketsStatus::values())->default(\App\Modules\SupportTickets\Enums\SupportTicketsStatus::OPEN());
            $table->foreignId('user_id')->constrained("users");
            $table->text("note")->nullable();
            $table->timestamps();
            $table->index("priority" );
            $table->index("status");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
