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
        Schema::create('series', function (Blueprint $table) {
            $table->bigIncrements('serie_id')->primaryKey();
            $table->text('title');
            $table->text('description')->nullable();
            // quyen rieng tu
            $table->enum('privacy',['public','private','anyone','schedule'])->default('public');
            // so luong bai viet trong serue nay
            $table->integer('articles');
            // viet tat cho title
            $table->string('slug');
            $table->string('address_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
