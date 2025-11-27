<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DetailUser extends Model
{
    use HasUuids;

    protected $table = 'detail_users';

    protected $fillable = [
        'user_id',
        'name',
        'nip',
        'npsn',
        'asal_sekolah',
        'jenis_sekolah',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
        'email_sekolah',
        'telp_sekolah',
        'web_sekolah',
        'kabupaten',
        'kecamatan',
        'alamat',
        'kelas',
        'tahun_ajaran',
        'semester',
    ];

    // 🔗 Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
