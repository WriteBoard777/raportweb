<?php

namespace App\Livewire\NilaiEkstra;

use Livewire\Component;
use App\Models\NilaiEkstra;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Form extends Component
{
    public $showForm = false;
    public $showDelete = false;

    public $siswaId;
    public $ekstrakurikulerId;

    public $nilai;       // A, B, C, D
    public $deskripsi;   // otomatis diisi

    #[On('openNilaiEkstraForm')]
    public function open($siswaId = null, $ekstrakurikulerId = null)
    {
        $this->siswaId = $siswaId;
        $this->ekstrakurikulerId = $ekstrakurikulerId;

        if (!$siswaId || !$ekstrakurikulerId) return;

        $this->resetValidation();
        $this->reset(['nilai', 'deskripsi']);

        $data = NilaiEkstra::where('siswa_id', $siswaId)
            ->where('ekstrakurikuler_id', $ekstrakurikulerId)
            ->first();

        if ($data) {
            $this->nilai = $data->nilai;
            $this->deskripsi = $data->deskripsi;
        }

        $this->showForm = true;
    }

    public function updatedNilai($value)
    {
        // Otomatis isi deskripsi berdasarkan nilai huruf
        $this->deskripsi = match ($value) {
            'A' => 'Sangat baik dalam mengikuti kegiatan.',
            'B' => 'Cukup aktif dan menunjukkan perkembangan baik.',
            'C' => 'Perlu lebih aktif dalam kegiatan.',
            'D' => 'Kurang berpartisipasi dalam kegiatan.',
            default => null,
        };
    }

    public function save()
    {
        $this->validate([
            'nilai' => 'required|in:A,B,C,D',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        NilaiEkstra::updateOrCreate(
            [
                'siswa_id' => $this->siswaId,
                'ekstrakurikuler_id' => $this->ekstrakurikulerId,
            ],
            [
                'user_id' => Auth::id(),
                'nilai' => $this->nilai,
                'deskripsi' => $this->deskripsi,
            ]
        );

        $this->reset(['showForm','siswaId','ekstrakurikulerId','nilai','deskripsi']);
        $this->dispatch('nilaiEkstraUpdated');
    }

    #[On('confirmDeleteNilaiEkstra')]
    public function confirmDelete($siswaId = null, $ekstrakurikulerId = null)
    {
        $this->siswaId = $siswaId;
        $this->ekstrakurikulerId = $ekstrakurikulerId;

        if (!$siswaId || !$ekstrakurikulerId) return;
        $this->showDelete = true;
    }

    public function delete()
    {
        if ($this->siswaId && $this->ekstrakurikulerId) {
            NilaiEkstra::where('siswa_id', $this->siswaId)
                ->where('ekstrakurikuler_id', $this->ekstrakurikulerId)
                ->delete();

            $this->reset(['showDelete','siswaId','ekstrakurikulerId','nilai','deskripsi']);
            $this->dispatch('nilaiEkstraUpdated');
        }
    }

    public function render()
    {
        return view('livewire.nilai-ekstra.form');
    }
}
