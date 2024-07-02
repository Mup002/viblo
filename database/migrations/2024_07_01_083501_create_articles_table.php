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
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('article_id')->primaryKey();
            $table->bigInteger('user_id');
            $table->bigInteger('serie_id')->nullable();
            $table->text('title');
            $table->text('content')->nullable();
            $table->boolean('is_publish')->default(true);
            // quyen rieng tu cua bai viet
            // $table->enum('privacy',['public','schedule','anyone','private'])->default('public');
            // cot nay se them neu quyen rieng tu = schedule
            $table->dateTime('published_at')->nullable();
            // dem so view cua bai viet
            $table->integer('views')->default(0);
            $table->text('description')->nullable();
            // viet tat cua title
            $table->string('slug');
            $table->string('img_url')->nullable();
            // so luong vote cua bai viet
            $table->integer('votes')->default(0);
            // trang thai duyet bai viet cua admin
            $table->boolean('is_accept')->default(false);
            // duong dan dan toi bai viet nay
            $table->string('address_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
