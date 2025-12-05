<?php

use App\Modules\Works\Enums\WorkStatusEnum;
use App\Modules\Works\Enums\WorkTypesEnum;
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
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string("company");
            $table->string("location");
            $table->enum('type', WorkTypesEnum::values());
            $table->string("salary_range");
            $table->text("requirements");
            $table->text("benefits");
            $table->enum('status', WorkStatusEnum::values())->default(WorkStatusEnum::ACTIVE());
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
        Schema::create('work_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('level');
            $table->foreignId('work_id')->constrained('works');
            $table->timestamps();
        });
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->decimal('ai_rate')->nullable();
            $table->boolean('accepted')->default(false)->nullable();
            $table->foreignId('work_id')->constrained('works');
            $table->foreignId('user_id')->constrained('users');
            $table->unique(['work_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
        Schema::dropIfExists('work_requirments');
        Schema::dropIfExists('applicants');
    }
};
