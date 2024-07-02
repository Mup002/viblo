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
        Schema::create('article_requests', function (Blueprint $table) {
            $table->bigIncrements('article_request_id')->primaryKey();
            $table->bigInteger('user_id');
            $table->bigInteger('article_id');
            $table->bigInteger('serie_id');
            $table->tinyInteger('is_accept')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_requests');
    }
};
