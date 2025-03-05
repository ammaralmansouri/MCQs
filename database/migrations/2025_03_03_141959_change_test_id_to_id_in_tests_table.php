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
        Schema::table('tests', function (Blueprint $table) {
              // Drop the 'test_id' column if it's being used as the primary key
              $table->dropColumn('test_id');

              // Add a new 'id' column as the primary key (if not already present)
              $table->id('id')->first(); // Move this to the first column position
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            
            // Rollback the changes: restore 'test_id' and drop the 'id'
            $table->dropColumn('id');
            $table->bigIncrements('test_id')->first();  // Restore 'test_id'
        });
    }
};
