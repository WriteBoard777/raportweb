<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nip',
        'email',
        'password',
        'npsn',
        'asal_sekolah',
        'jenis_sekolah',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'kelas',
        'alamat',
        'tahun_ajaran',
        'semester',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // 🔗 Relasi
    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function tps()
    {
        return $this->hasMany(Tp::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }

    public function mapels()
    {
        return $this->belongsToMany(Mapel::class)->withTimestamps();
    }

    public function ekstrakurikulers()
    {
        return $this->hasMany(Ekstrakurikuler::class);
    }

    public function nilaiEkstras()
    {
        return $this->hasMany(NilaiEkstra::class);
    }

}
