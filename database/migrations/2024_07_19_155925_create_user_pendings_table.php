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
        Schema::create('user_pendings', function (Blueprint $table) {
            $table -> bigIncrements('up_id')->primaryKey();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('username');
            $table->string('display_name')->nullable();
            $table->string('real_name')->nullable();
            $table -> string('verify_token')->unique();
            $table -> dateTime('expires_at');
            $table->timestamps();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pendings');
    }
};
