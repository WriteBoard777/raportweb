<?php

namespace App\Livewire\Nilai;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Nilai;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class FormMassal extends Component
{
    public $showForm = false;
    public $mapelId;
    public $siswas = [];
    public $nilaiData = [];

    #[On('openNilaiMassal')]
    public function open($mapelId = null)
    {
        if (!$mapelId) return;

        $this->mapelId = $mapelId;
        $this->showForm = true;

        $userId = Auth::id();

        // Ambil semua siswa milik user login
        $this->siswas = Siswa::where('user_id', $userId)->orderBy('nama')->get();

        // Isi nilai existing (kalau ada) — versi foreach yang jelas dan aman untuk tooling
        $this->nilaiData = []; // pastikan kosong dulu

        foreach ($this->siswas as $siswa) {
            $nilai = Nilai::where('siswa_id', $siswa->id)
                ->where('mapel_id', $mapelId)
                ->first();

            // gunakan string key agar consistent saat binding Livewire: "nilaiData.{$siswaId}.nilai_harian"
            $siswaIdKey = (string) $siswa->id;

            $this->nilaiData[$siswaIdKey] = [
                'nilai_harian' => $nilai->nilai_harian ?? '',
                'nilai_uts'    => $nilai->nilai_uts ?? '',
                'nilai_uas'    => $nilai->nilai_uas ?? '',
            ];
        }
    }

    public function save()
    {
        $userId = Auth::id();
    
        foreach ($this->nilaiData as $siswaId => $nilai) {
            if (!is_array($nilai)) continue;
    
            // konversi string kosong menjadi null
            $nilaiHarian = $nilai['nilai_harian'] === '' ? null : $nilai['nilai_harian'];
            $nilaiUts    = $nilai['nilai_uts'] === '' ? null : $nilai['nilai_uts'];
            $nilaiUas    = $nilai['nilai_uas'] === '' ? null : $nilai['nilai_uas'];
    
            Nilai::updateOrCreate(
                ['siswa_id' => $siswaId, 'mapel_id' => $this->mapelId],
                [
                    'user_id' => $userId,
                    'nilai_harian' => $nilaiHarian,
                    'nilai_uts' => $nilaiUts,
                    'nilai_uas' => $nilaiUas,
                ]
            );
        }
    
        $this->showForm = false;
        $this->dispatch('nilaiUpdated');
    }

    public function render()
    {
        return view('livewire.nilai.form-massal');
    }
}
