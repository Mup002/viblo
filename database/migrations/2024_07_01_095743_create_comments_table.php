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
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('comment_id')->primaryKey();
            $table->bigInteger('user_id');
            $table->text('content');
            // loai doi tuong ma cmt nay hien thi : bai viet, cau hoi...
            $table->string('commentable_type');
            // id doi tuong ma cmt nay hien thi
            $table->bigInteger('commentable_id');
            // neu trung ca type va id thi cmtrepply_id phai khac 0
            $table->bigInteger('cmtreply_id')->default(0);
            $table->integer('reputation_condition')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
