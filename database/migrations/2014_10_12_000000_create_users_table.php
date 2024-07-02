<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id')->primaryKey();
            $table->bigInteger('role_id');
            //  ten hien thi
            $table->string('display_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('sex')->nullable();
            $table->string('real_name');
            $table->string('address')->nullable();
            $table->string('college')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            // so diem tich luy
            $table->integer('reputation')->default(0);
            // so tag ma user nay dang follow
            $table->integer('tag_follow')->default(0);
            // so user ma user nay dang follow
            $table->integer('user_follow')->default(0);
            // so bai viet ma user nay da dang
            $table->integer('article')->default(0);
            // so bookmark user da su dung
            $table->integer('bookmark')->default(0);
            // so cau hoi user da dat
            $table->integer('question')->default(0);
            // so cau tra loi cua user nay
            $table->integer('answer')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
