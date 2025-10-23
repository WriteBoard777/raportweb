<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Mapel extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama_mapel',
        'kode_mapel',
    ];

    // 🔗 Relasi
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function tps()
    {
        return $this->hasMany(Tp::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}
