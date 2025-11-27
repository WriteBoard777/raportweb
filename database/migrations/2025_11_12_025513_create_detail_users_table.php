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
        Schema::create('detail_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');

            $table->string('name')->nullable();
            $table->string('nip')->unique();

            $table->string('npsn')->nullable();
            $table->enum('jenis_sekolah', ['Negeri', 'Swasta'])->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('nama_kepala_sekolah')->nullable();
            $table->string('nip_kepala_sekolah')->nullable();
            
            $table->string('email_sekolah')->nullable();
            $table->string('telp_sekolah')->nullable();
            $table->string('web_sekolah')->nullable();
            $table->text('kabupaten')->nullable();
            $table->text('kecamatan')->nullable();
            $table->text('alamat')->nullable();

            $table->string('kelas')->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->string('semester')->nullable();
            $table->timestamps();

            // Relasi ke users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_users');
    }
};
