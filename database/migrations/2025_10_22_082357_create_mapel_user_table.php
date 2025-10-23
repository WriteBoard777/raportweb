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
        Schema::create('mapel_user', function (Blueprint $table) {
            $table->id();
            
            $table->uuid('user_id'); // ubah ke uuid
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->uuid('mapel_id'); // ubah ke uuid
            $table->foreign('mapel_id')->references('id')->on('mapels')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel_user');
    }
};
