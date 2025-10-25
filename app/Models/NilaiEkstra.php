<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NilaiEkstra extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'siswa_id',
        'ekstrakurikuler_id',
        'nilai',
        'deskripsi',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = Str::uuid();
            }
        });
    }

    /** Relasi ke User (guru penginput) */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Relasi ke Siswa */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /** Relasi ke Ekstrakurikuler */
    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }
}
