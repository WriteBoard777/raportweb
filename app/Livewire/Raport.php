<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;

class Raport extends Component
{
    public $raport = [];
    public $search = '';

    public function mount()
    {
        $this->loadRaport();
    }

    public function updatedSearch()
    {
        $this->loadRaport();
    }

    public function loadRaport()
    {
        $user = Auth::user();

        // Ambil semua siswa milik user login (wali kelas)
        $siswas = Siswa::where('user_id', $user->id)
            ->where('nama', 'like', "%{$this->search}%")
            ->get();

        // Ambil nilai untuk semua siswa tersebut
        $nilaiSemua = Nilai::whereIn('siswa_id', $siswas->pluck('id'))
            ->with('mapel')
            ->get()
            ->groupBy('siswa_id');

        $data = [];

        foreach ($siswas as $siswa) {
            $nilaiRecords = $nilaiSemua->get($siswa->id, collect());
            $totalNilai = 0;
            $jumlahMapel = $nilaiRecords->count();
            $nilaiDetail = [];

            foreach ($nilaiRecords as $n) {
                $nilaiAkhir = round((($n->nilai_harian ?? 0) + ($n->nilai_uts ?? 0) + ($n->nilai_uas ?? 0)) / 3);
                $totalNilai += $nilaiAkhir;

                $nilaiDetail[] = [
                    'mapel' => $n->mapel->nama_mapel ?? '-',
                    'nilai_akhir' => $nilaiAkhir,
                ];
            }

            $data[] = [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'rata_rata' => $jumlahMapel > 0 ? round($totalNilai / $jumlahMapel, 2) : 0,
                'nilai_detail' => $nilaiDetail,
            ];
        }

        $this->raport = $data;
    }

    public function render()
    {
        return view('livewire.raport', [
            'raport' => $this->raport,
        ]);
    }
}
