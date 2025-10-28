<?php

namespace App\Livewire\Absen;

use Livewire\Component;
use App\Models\Absen;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $showForm = false;
    public $showDelete = false;

    public $siswaId;
    public $sakit;
    public $izin;
    public $alfa;

    #[On('openAbsenForm')]
    public function open($siswaId = null)
    {
        $this->resetValidation();
        $this->reset(['sakit','izin','alfa']);
        $this->siswaId = $siswaId;

        if (!$this->siswaId) return;

        $userId = Auth::id();
        $absen = Absen::where('siswa_id', $this->siswaId)
            ->where('user_id', $userId)
            ->first();

        if ($absen) {
            $this->sakit = $absen->sakit;
            $this->izin = $absen->izin;
            $this->alfa = $absen->alfa;
        }

        $this->showForm = true;
    }

    public function save()
    {
        $this->validate([
            'sakit' => 'nullable|integer|min:0|max:365',
            'izin' => 'nullable|integer|min:0|max:365',
            'alfa' => 'nullable|integer|min:0|max:365',
        ]);

        Absen::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'siswa_id' => $this->siswaId,
            ],
            [
                'sakit' => $this->sakit ?? 0,
                'izin' => $this->izin ?? 0,
                'alfa' => $this->alfa ?? 0,
            ]
        );

        $this->reset(['showForm','siswaId','sakit','izin','alfa']);
        $this->dispatch('absenUpdated');
    }

    #[On('confirmDeleteAbsen')]
    public function confirmDelete($siswaId = null)
    {
        $this->siswaId = $siswaId;
        $this->showDelete = true;
    }

    public function delete()
    {
        if ($this->siswaId) {
            Absen::where('user_id', Auth::id())
                ->where('siswa_id', $this->siswaId)
                ->delete();

            $this->reset(['showDelete','siswaId','sakit','izin','alfa']);
            $this->dispatch('absenUpdated');
        }
    }

    public function render()
    {
        return view('livewire.absen.form');
    }
}

