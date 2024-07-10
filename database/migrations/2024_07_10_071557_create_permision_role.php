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
        Schema::create('permission_role',function(Blueprint $table){
            $table->bigIncrements('id')->primaryKey();
            $table->foreignId('role_id')->references('role_id')->on('roles')->onDelete('cascade');
            $table->foreignId('permission_id')->references('permission_id')->on('permissions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
