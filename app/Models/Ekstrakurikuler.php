<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ekstrakurikuler extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama_ekstra',
        // tambahkan kolom lain kalau di migration ada, mis. 'kode' atau 'deskripsi'
    ];

    // 🔗 Relasi many-to-many ke User (pivot table: ekstrakurikuler_user or similar)
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // 🔗 Relasi ke NilaiEkstra (satu ekstrakurikuler --> banyak entri nilai)
    public function nilai_ekstras()
    {
        return $this->hasMany(NilaiEkstra::class, 'ekstrakurikuler_id');
    }
}
