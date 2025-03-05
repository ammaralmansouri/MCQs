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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_correct');
            $table->foreignId('user_test_id')->constrained('user_test', 'id')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions', 'id')->onDelete('cascade');
            $table->foreignId('choice_id')->constrained('choices', 'id')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
