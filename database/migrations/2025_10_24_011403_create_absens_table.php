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
         Schema::create('absens', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke user (guru penginput)
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Relasi ke siswa
            $table->uuid('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');

            // Kolom data absensi
            $table->integer('sakit')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('alfa')->default(0);

            // Informasi periode
            $table->string('semester');
            $table->string('tahun_ajaran');

            $table->timestamps();

            // Unik per siswa per semester per tahun
            $table->unique(['user_id', 'siswa_id', 'semester', 'tahun_ajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
