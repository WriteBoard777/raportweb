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
        Schema::create('nilais', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id'); // ubah ke uuid
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->uuid('siswa_id'); // ubah ke uuid
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
            
            $table->uuid('mapel_id'); // ubah ke uuid
            $table->foreign('mapel_id')->references('id')->on('mapels')->onDelete('cascade');
            
            $table->integer('nilai_harian')->nullable();
            $table->integer('nilai_uts')->nullable();
            $table->integer('nilai_uas')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'siswa_id', 'mapel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
