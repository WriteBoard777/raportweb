<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Siswa extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'nisn',
        'nis',
        'nama',
        'jenis_kelamin',
        'nama_orang_tua',
    ];

    protected $casts = [
        'nama_orang_tua' => 'array',
    ];

    // 🔗 Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}

