<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_test', function (Blueprint $table) {
            $table->id();
            $table->integer('score');
            $table->integer('number_of_total_questions');
            $table->integer('number_of_answred_questions');
            $table->integer('number_of_correct_answers');
            $table->integer('taken_time_to_complete_the_test');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('test_id')->constrained('tests', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_test');
    }
};
