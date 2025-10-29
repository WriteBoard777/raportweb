<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $peringkat = [];

    public function mount()
    {
        $this->loadPeringkat();
    }

    public function loadPeringkat()
    {
        $user = Auth::user();

        $siswas = Siswa::where('user_id', $user->id)->get();
        $nilaiSemua = Nilai::whereIn('siswa_id', $siswas->pluck('id'))->get()->groupBy('siswa_id');

        $data = [];

        foreach ($siswas as $siswa) {
            $totalNilaiAkhir = 0;
            $jumlahMapel = 0;
            $nilaiRecords = $nilaiSemua->get($siswa->id, collect());

            if ($nilaiRecords->isNotEmpty()) {
                foreach ($nilaiRecords as $n) {
                    if ($n->nilai_harian !== null || $n->nilai_uts !== null || $n->nilai_uas !== null) {
                        $sumParts = ($n->nilai_harian ?? 0) + ($n->nilai_uts ?? 0) + ($n->nilai_uas ?? 0);
                        $totalNilaiAkhir += round($sumParts / 3);
                        $jumlahMapel++;
                    }
                }
            }

            $rataRata = $jumlahMapel ? round($totalNilaiAkhir / $jumlahMapel, 2) : 0;

            $data[] = [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'rata_rata' => $rataRata,
            ];
        }

        $this->peringkat = collect($data)
            ->sortByDesc('rata_rata')
            ->take(10)
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'peringkat' => $this->peringkat,
        ]);
    }
}
