<?php

use App\Modules\N8n\Enums\WorkflowStatusEnum;
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
        Schema::create('workflow_calls', function (Blueprint $table) {
            $table->id();
            $table->uuid('workflow_id');
            $table->string('type');
            $table->unsignedInteger('total_chunks')->default(1);
            $table->unsignedInteger('chunk_number')->default(1);
            $table->unsignedInteger('attempts')->default(1);
            $table->enum('status', WorkflowStatusEnum::values())->default(WorkflowStatusEnum::RUNNING());
            $table->json('payload')->nullable();
            $table->json("results")->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamp('callback_received_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wokrflow_calls');
    }
};
