<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ekstrakurikuler extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'nama_ekstrakurikuler',
    ];

    // 🔗 Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nilai_ekstras()
    {
        return $this->hasMany(NilaiEkstra::class);
    }
}
