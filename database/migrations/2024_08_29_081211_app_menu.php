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
        Schema::create('app_menu', function (Blueprint $table) {
            $table->string('menu_id', 5)->primary();
            $table->string('menu_name', 100);
            $table->string('menu_icon', 150);
            $table->string('menu_level', 2);
            $table->enum('menu_st', ['yes', 'no'])->default('yes');
            $table->string('menu_url', 100)->nullable();
            $table->string('menu_parent', 5)->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('app_menu');
    }
};
