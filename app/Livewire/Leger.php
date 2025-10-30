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
        $userId = Auth::id();

        $siswas = Siswa::where('user_id', $userId)
            ->where('nama', 'like', "%{$this->search}%")
            ->orderBy('nama')
            ->paginate(10);

        $nilaiData = collect();
        if (count($this->mapelIds)) {
            $nilaiData = Nilai::whereIn('mapel_id', $this->mapelIds)
                ->whereIn('siswa_id', $siswas->pluck('id'))
                ->get()
                ->groupBy('siswa_id');
        }

        // Hitung total nilai untuk peringkat
        $ranking = [];
        foreach ($siswas as $siswa) {
            $total = 0;
            foreach ($this->activeMapels as $mapel) {
                $nilai = isset($nilaiData[$siswa->id])
                    ? $nilaiData[$siswa->id]->firstWhere('mapel_id', $mapel->id)
                    : null;
            
                $nilaiAkhir = $nilai
                    ? round(($nilai->nilai_harian + $nilai->nilai_uts + $nilai->nilai_uas) / 3)
                    : null;
            
                $total += $nilaiAkhir ?? 0;
            }
            $ranking[$siswa->id] = $total;
        }

        // Urutkan dari terbesar ke terkecil
        arsort($ranking);

        // Tentukan peringkat
        $ranks = [];
        $rank = 1;
        foreach (array_keys($ranking) as $siswaId) {
            $ranks[$siswaId] = $rank++;
        }

        return view('livewire.leger', compact('siswas', 'nilaiData', 'ranks'));
    }

    public function exportPdf()
    {
        $userId = Auth::id();

        // Ambil mapel milik user
        $mapels = Mapel::orderBy('nama_mapel')
            ->get()
            ->filter(fn($mapel) =>
                DB::table('mapel_user')
                    ->where('user_id', $userId)
                    ->where('mapel_id', $mapel->id)
                    ->exists()
            );

        $mapelIds = $mapels->pluck('id')->toArray();

        // 🔹 Filter siswa milik user yang login
        $siswas = Siswa::where('user_id', $userId)
            ->orderBy('nama')
            ->get();

        // 🔹 Ambil nilai hanya dari mapel & siswa milik user
        $nilaiData = Nilai::whereIn('mapel_id', $mapelIds)
            ->whereIn('siswa_id', $siswas->pluck('id'))
            ->get()
            ->groupBy('siswa_id');

        // 🔹 Hitung total nilai & peringkat
        $ranking = [];
        foreach ($siswas as $siswa) {
            $total = 0;
            foreach ($mapels as $mapel) {
                $nilai = $nilaiData[$siswa->id]->firstWhere('mapel_id', $mapel->id) ?? null;
                $nilaiAkhir = $nilai
                    ? round(($nilai->nilai_harian + $nilai->nilai_uts + $nilai->nilai_uas) / 3)
                    : 0;
                $total += $nilaiAkhir;
            }
            $ranking[$siswa->id] = $total;
        }

        // 🔹 Urutkan peringkat
        arsort($ranking);

        $ranks = [];
        $rank = 1;
        foreach (array_keys($ranking) as $siswaId) {
            $ranks[$siswaId] = $rank++;
        }

        // 🔹 Generate PDF
        $pdf = Pdf::loadView('pdf.leger_kelas', compact('siswas', 'mapels', 'nilaiData', 'ranks'))
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(fn() => print($pdf->output()), 'leger_nilai_kelas.pdf');
    }
}
