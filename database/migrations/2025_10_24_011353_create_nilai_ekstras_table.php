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
        Schema::create('nilai_ekstras', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id'); // ubah ke uuid
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->uuid('siswa_id'); // ubah ke uuid
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
            
            $table->uuid('ekstrakurikuler_id'); // ubah ke uuid
            $table->foreign('ekstrakurikuler_id')->references('id')->on('ekstrakurikulers')->onDelete('cascade');
            
            $table->string('nilai')->nullable();
            $table->string('deskripsi')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'siswa_id', 'ekstrakurikuler_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_ekstras');
    }
};
