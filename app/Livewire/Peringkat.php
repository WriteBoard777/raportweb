<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Nilai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class Peringkat extends Component
{
    public $peringkat = [];
    public $search = '';

    public function mount()
    {
        $this->loadPeringkat();
    }

    public function updatedSearch()
    {
        $this->loadPeringkat();
    }

    public function loadPeringkat()
    {
        $user = Auth::user();

        // Ambil semua siswa milik user login (filter by user_id)
        $siswas = Siswa::where('user_id', $user->id)
            ->where('nama', 'like', "%{$this->search}%")
            ->get();

        // Ambil semua nilai untuk siswa tersebut dalam satu query (hindari N+1)
        $nilaiSemua = Nilai::whereIn('siswa_id', $siswas->pluck('id'))->get()->groupBy('siswa_id');

        $data = [];

        foreach ($siswas as $siswa) {
            $totalNilaiAkhir = 0;
            $nilaiRecords = $nilaiSemua->get($siswa->id, collect());

            // Jika tidak ada nilai untuk siswa ini, total tetap 0
            if ($nilaiRecords->isNotEmpty()) {
                foreach ($nilaiRecords as $n) {
                    // Jika semua tiga nilai tersedia, hitung nilai akhir.
                    // Jika kamu ingin menghitung walau hanya sebagian tersedia,
                    // ubah kondisi berikut sesuai kebutuhan.
                    if ($n->nilai_harian !== null || $n->nilai_uts !== null || $n->nilai_uas !== null) {
                        // jika salah satu null, kita hitung dengan angka yg ada (menghindari error)
                        $sumParts = ($n->nilai_harian ?? 0) + ($n->nilai_uts ?? 0) + ($n->nilai_uas ?? 0);
                        // gunakan pembagi 3 seperti kebijakan sebelumnya
                        $nilaiAkhir = round($sumParts / 3);
                        $totalNilaiAkhir += $nilaiAkhir;
                    }
                }
            }

            $data[] = [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'total_nilai' => $totalNilaiAkhir,
            ];
        }

        // Urutkan dari total terbesar ke terkecil
        $this->peringkat = collect($data)
            ->sortByDesc('total_nilai')
            ->values()
            ->toArray();
    }

    public function exportPdf()
    {
        $pdf = Pdf::loadView('pdf.peringkat', [
            'peringkat' => $this->peringkat,
            'user' => Auth::user(),
        ]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'peringkat_siswa.pdf'
        );
    }

    public function render()
    {
        return view('livewire.peringkat', [
            'peringkat' => $this->peringkat,
        ]);
    }
}
