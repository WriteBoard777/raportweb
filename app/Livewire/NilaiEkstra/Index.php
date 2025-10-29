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
    public $ekstrakurikulerId;
    public $activeEkstras;

    protected $listeners = ['nilaiEkstraUpdated' => 'refreshData'];

    public function mount()
    {
        $userId = Auth::id();

        // 🔹 Ambil ekstrakurikuler milik user login
        $this->activeEkstras = Ekstrakurikuler::where('user_id', $userId)
            ->orderBy('nama_ekstrakurikuler')
            ->get();

        $this->ekstrakurikulerId = $this->activeEkstras->first()?->id ?? null;
    }

    public function updatedEkstrakurikulerId()
    {
        $this->resetPage();
    }

    public function refreshData()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userId = Auth::id();

        // 🔹 Hanya siswa milik user login
        $siswas = Siswa::where('user_id', $userId)
            ->when($this->search, fn($q) =>
                $q->where('nama', 'like', "%{$this->search}%")
                  ->orWhere('nisn', 'like', "%{$this->search}%")
                  ->orWhere('nis', 'like', "%{$this->search}%")
            )
            ->orderBy('nama')
            ->paginate(10);

        // 🔹 Ambil nilai ekstra untuk siswa & ekstra terpilih
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
