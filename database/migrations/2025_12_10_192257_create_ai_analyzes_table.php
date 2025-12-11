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
        Schema::create('ai_analyzes', function (Blueprint $table) {
            $table->id();
            $table->json('data');
            $table->string('type');
            $table->morphs('analyze');
            $table->unique(['analyze_id', 'analyze_type', 'type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_analyzes');
    }
};
