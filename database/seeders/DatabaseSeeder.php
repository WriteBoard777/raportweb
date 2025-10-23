<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Mapel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $mapelList = [
            ['nama_mapel' => 'Matematika', 'kode_mapel' => 'MTK'],
            ['nama_mapel' => 'Bahasa Indonesia', 'kode_mapel' => 'BINDO'],
            ['nama_mapel' => 'IPAS', 'kode_mapel' => 'IPAS'],
            ['nama_mapel' => 'Pendidikan Pancasila', 'kode_mapel' => 'PP'],
            ['nama_mapel' => 'Pendidikan Agama Islam', 'kode_mapel' => 'PAI'],
            ['nama_mapel' => 'PJOK', 'kode_mapel' => 'PJOK'],
            ['nama_mapel' => 'Bahasa Inggris', 'kode_mapel' => 'BING'],
            ['nama_mapel' => 'Bahasa Cirebon', 'kode_mapel' => 'BC'],
            ['nama_mapel' => 'Bahasa Sunda', 'kode_mapel' => 'BS'],
            ['nama_mapel' => 'Seni Rupa', 'kode_mapel' => 'SR'],
            ['nama_mapel' => 'Seni Tari', 'kode_mapel' => 'STI'],
            ['nama_mapel' => 'Seni Teater', 'kode_mapel' => 'STA'],
            ['nama_mapel' => 'Seni Musik', 'kode_mapel' => 'SM'],
        ];

        foreach ($mapelList as $mapel) {
            Mapel::firstOrCreate(['nama_mapel' => $mapel['nama_mapel']], $mapel);
        }
    }
}
