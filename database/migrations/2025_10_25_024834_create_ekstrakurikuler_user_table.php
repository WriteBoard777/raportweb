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
        Schema::create('ekstrakurikuler_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ekstrakurikuler_id');
            $table->uuid('user_id');

            $table->foreign('ekstrakurikuler_id')->references('id')->on('ekstrakurikulers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikuler_user');
    }
};
