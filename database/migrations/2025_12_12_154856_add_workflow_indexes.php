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
        Schema::table('workflow_calls', function (Blueprint $table) {
            
            if (!Schema::hasIndex('workflow_calls', 'workflow_type_index')) {
                $table->index('type', 'workflow_type_index');
            }
            
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('workflow_calls', function (Blueprint $table) {
            $table->dropIndex('workflow_type_index');
            
        });
    }
};
