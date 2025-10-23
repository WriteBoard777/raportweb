<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Nilai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class Leger extends Component
{
    use WithPagination;

    public $search = '';
    public $activeMapels; // mapel aktif untuk user
    public $mapelIds = [];

    protected $listeners = ['nilaiUpdated' => 'refreshData'];

    public function mount()
    {
        $userId = Auth::id();

        // Ambil mapel aktif khusus untuk user login
        $this->activeMapels = Mapel::orderBy('nama_mapel')
            ->get()
            ->filter(fn($mapel) =>
                DB::table('mapel_user')
                    ->where('user_id', $userId)
                    ->where('mapel_id', $mapel->id)
                    ->exists()
            );

        $this->mapelIds = $this->activeMapels->pluck('id')->toArray();
    }

    public function refreshData()
    {
        $this->resetPage();
    }

    public function render()
    {
        $siswas = Siswa::where('nama', 'like', "%{$this->search}%")
            ->orderBy('nama')
            ->paginate(10);

        // Ambil semua nilai siswa hanya untuk mapel aktif user
        $nilaiData = collect();
        if (count($this->mapelIds)) {
            $nilaiData = Nilai::whereIn('mapel_id', $this->mapelIds)
                ->whereIn('siswa_id', $siswas->pluck('id'))
                ->get()
                ->groupBy('siswa_id');
        }

        return view('livewire.leger', compact('siswas', 'nilaiData'));
    }

    public function exportPdf()
    {
        $userId = Auth::id();

        // Ambil mapel aktif user
        $mapels = Mapel::orderBy('nama_mapel')
            ->get()
            ->filter(fn($mapel) =>
                DB::table('mapel_user')
                    ->where('user_id', $userId)
                    ->where('mapel_id', $mapel->id)
                    ->exists()
            );

        $mapelIds = $mapels->pluck('id')->toArray();

        $siswas = Siswa::orderBy('nama')->get();

        $nilaiData = Nilai::whereIn('mapel_id', $mapelIds)
            ->get()
            ->groupBy('siswa_id');

        $pdf = Pdf::loadView('pdf.leger_kelas', compact('siswas', 'mapels', 'nilaiData'))
            ->setPaper('a4','landscape');

        return response()->streamDownload(
            fn() => print($pdf->output()), 
            'leger_nilai_kelas.pdf'
        );
    }
}
