<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Absen extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'siswa_id',
        'sakit',
        'izin',
        'alfa',
        'semester',
        'tahun_ajaran',
    ];

    // 🔗 Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
