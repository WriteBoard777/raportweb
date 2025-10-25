<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nama_ekstra'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = Str::uuid();
            }
        });
    }

    /**
     * Relasi ke User (many-to-many)
     * Setiap ekstrakurikuler bisa dimiliki banyak user/guru
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'ekstrakurikuler_user', 'ekstrakurikuler_id', 'user_id');
    }

    /**
     * Relasi ke NilaiEkstra (one-to-many)
     * Setiap ekstrakurikuler memiliki banyak nilai
     */
    public function nilaiEkstras()
    {
        return $this->hasMany(NilaiEkstra::class, 'ekstrakurikuler_id');
    }
}
