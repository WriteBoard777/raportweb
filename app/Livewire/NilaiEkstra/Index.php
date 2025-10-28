<?php

namespace App\Livewire\NilaiEkstra;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Siswa;
use App\Models\Ekstrakurikuler;
use App\Models\NilaiEkstra;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $ekstrakurikulerId;        // ID ekstrakurikuler terpilih
    public $activeEkstras;   // Daftar ekstrakurikuler milik user

    protected $listeners = ['nilaiEkstraUpdated' => 'refreshData'];

    public function mount()
    {
        $userId = Auth::id();

        // 🔹 Ambil hanya ekstrakurikuler milik user login
        $this->activeEkstras = Ekstrakurikuler::where('user_id', $userId)
            ->orderBy('nama_ekstrakurikuler')
            ->get();

        $this->ekstrakurikulerId = $this->activeEkstras->first()?->id ?? null;
    }

    public function updatedEkstraId()
    {
        $this->resetPage();
    }

    public function refreshData()
    {
        $this->resetPage();
    }

    public function render()
    {
        // 🔹 Filter siswa berdasarkan pencarian
        $siswas = Siswa::where('nama', 'like', "%{$this->search}%")
            ->orderBy('nama')
            ->paginate(10);

        // 🔹 Ambil nilai ekstrakurikuler untuk siswa & ekstra terpilih
        $nilaiData = collect();
        if ($this->ekstrakurikulerId) {
            $nilaiData = NilaiEkstra::where('ekstrakurikuler_id', $this->ekstrakurikulerId)
                ->whereIn('siswa_id', $siswas->pluck('id'))
                ->get()
                ->keyBy('siswa_id');
        }

        return view('livewire.nilai-ekstra.index', [
            'siswas' => $siswas,
            'nilaiData' => $nilaiData,
        ]);
    }
}
