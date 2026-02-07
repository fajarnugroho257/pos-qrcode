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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('role_id', 5);
            $table->string('username', 100);
            $table->string('password');
            $table->string('name')->nullable();
            $table->enum('user_st', ['yes', 'no'])->default('yes');
            $table->timestamps();
            // foreign key
            $table->foreign('role_id')->references('role_id')->on('app_role')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
