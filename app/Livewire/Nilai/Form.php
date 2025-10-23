<?php

namespace App\Livewire\Nilai;

use Livewire\Component;
use App\Models\Nilai;
use App\Models\Siswa;

// Import atribut #[On]
use Livewire\Attributes\On; 
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $showForm = false;
    public $showDelete = false;

    public $siswaId;
    public $mapelId;

    public $nilaiHarian;
    public $nilaiUTS;
    public $nilaiUAS;

    // Menghapus properti $listeners.
    // protected $listeners = [
    //     'openNilaiForm' => 'open',
    //     'confirmDeleteNilai' => 'confirmDelete',
    // ];

    // Menggunakan atribut #[On] untuk event 'openNilaiForm'.
    #[On('openNilaiForm')]
    // Menerima parameter secara langsung, bukan sebagai array tunggal $data.
    // Jika event dikirim dengan {siswaId: X, mapelId: Y}, Livewire 3 
    // akan secara otomatis memetakan ke parameter yang sesuai.
    public function open($siswaId = null, $mapelId = null)
    {
        // Parameter langsung diterima (lebih bersih dari $data['key'] ?? null)
        $this->siswaId = $siswaId;
        $this->mapelId = $mapelId;
        
        if (!$this->siswaId || !$this->mapelId) return;

        $this->resetValidation();
        // Hanya reset properti form, biarkan siswaId dan mapelId terisi dari parameter
        $this->reset(['nilaiHarian','nilaiUTS','nilaiUAS']); 

        // Ambil nilai siswa sesuai mapel yang dikirim
        $nilai = Nilai::where('siswa_id', $this->siswaId)
            ->where('mapel_id', $this->mapelId)
            ->first();

        if ($nilai) {
            $this->nilaiHarian = $nilai->nilai_harian;
            $this->nilaiUTS = $nilai->nilai_uts;
            $this->nilaiUAS = $nilai->nilai_uas;
        } else {
            // Pastikan nilai form bersih jika data tidak ditemukan
            $this->reset(['nilaiHarian','nilaiUTS','nilaiUAS']);
        }

        $this->showForm = true;
    }

    public function save()
    {
        $this->validate([
            'nilaiHarian' => 'nullable|integer|min:0|max:100',
            'nilaiUTS' => 'nullable|integer|min:0|max:100',
            'nilaiUAS' => 'nullable|integer|min:0|max:100',
        ]);

        Nilai::updateOrCreate(
            [
                'siswa_id' => $this->siswaId,
                'mapel_id' => $this->mapelId,
            ],
            [
                'user_id' => Auth::id(),
                'nilai_harian' => $this->nilaiHarian,
                'nilai_uts' => $this->nilaiUTS,
                'nilai_uas' => $this->nilaiUAS,
            ]
        );

        $this->reset(['showForm','siswaId','mapelId','nilaiHarian','nilaiUTS','nilaiUAS']);
        
        // Menggunakan $this->dispatch() (Livewire 3)
        $this->dispatch('nilaiUpdated'); 
    }

    // Menggunakan atribut #[On] untuk event 'confirmDeleteNilai'
    #[On('confirmDeleteNilai')]
    public function confirmDelete($siswaId = null, $mapelId = null)
    {
        // Parameter langsung diterima dari dispatch
        $this->siswaId = $siswaId;
        $this->mapelId = $mapelId;

        if (!$this->siswaId || !$this->mapelId) return;

        $this->showDelete = true;
    }


    public function delete()
    {
        if ($this->siswaId && $this->mapelId) {
            Nilai::where('siswa_id', $this->siswaId)
                ->where('mapel_id', $this->mapelId)
                ->delete();

            $this->reset(['showDelete','siswaId','mapelId','nilaiHarian','nilaiUTS','nilaiUAS']);
            // Menggunakan $this->dispatch() (Livewire 3)
            $this->dispatch('nilaiUpdated'); 
        }
    }

    public function render()
    {
        return view('livewire.nilai.form');
    }
}