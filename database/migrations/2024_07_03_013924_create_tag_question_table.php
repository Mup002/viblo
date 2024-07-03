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
        Schema::create('tag_question', function (Blueprint $table) {
            $table->bigIncrements('id')->primaryKey();
            $table->foreignId('tag_id')->references('tag_id')->on('tags')->onDelete('cascade');
            $table->foreignId('question_id')->references('question_id')->on('questions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_question');
    }
};
