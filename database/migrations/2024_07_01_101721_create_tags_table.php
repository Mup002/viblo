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
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements("tag_id")->primaryKey();
            $table->string('tagname');
            // so luong bai viet su dung tag nay
            $table->integer('articles')->default(0);
            // so luong cau hoi su dung tag nay
            $table->integer('questions')->default(0);
            // so luong nguoi follow bai tag nay
            $table->integer('follows')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
