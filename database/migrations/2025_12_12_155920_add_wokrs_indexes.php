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
        Schema::table('works', function (Blueprint $table) {
            
            if (!Schema::hasIndex('works', 'works_type_index')) {
                $table->index('type', 'works_type_index');
            }
            
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropIndex('works_type_index');
            
        });
    }
};
