<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Nilai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PeringkatPiagam extends Component
{
    public $siswaId;
    public $peringkat;
    public $nomorSurat;
    public $tanggalPiagam;
    public $lokasi;
    public $kecamatan;
    public $telpSekolah;
    public $emailSekolah;
    public $websiteSekolah;

    // tambahan untuk ditampilkan di view
    public $totalNilaiAkhir = 0;
    public $jumlahMapel = 0;

    public function mount($siswaId, $peringkat)
    {
        $this->siswaId = $siswaId;
        $this->peringkat = $peringkat;
        $this->tanggalPiagam = now()->toDateString();
    }

    public function exportPdf()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->findOrFail($this->siswaId);

        // Ambil nilai siswa
        $nilaiRecords = Nilai::where('siswa_id', $siswa->id)->get();

        $totalNilaiAkhir = 0;
        $jumlahMapel = $nilaiRecords->count();

        if ($nilaiRecords->isNotEmpty()) {
            foreach ($nilaiRecords as $n) {
                if ($n->nilai_harian !== null || $n->nilai_uts !== null || $n->nilai_uas !== null) {
                    $sumParts = ($n->nilai_harian ?? 0) + ($n->nilai_uts ?? 0) + ($n->nilai_uas ?? 0);
                    $nilaiAkhir = round($sumParts / 3);
                    $totalNilaiAkhir += $nilaiAkhir;
                }
            }
        }

        $pdf = Pdf::loadView('pdf.piagam_peringkat', [
            'user' => $user,
            'siswa' => $siswa,
            'peringkat' => $this->peringkat,
            'totalNilai' => $totalNilaiAkhir,
            'jumlahMapel' => $jumlahMapel,
            'nomorSurat' => $this->nomorSurat ?: '---',
            'lokasi' => $this->lokasi ?: '-',
            'kecamatan' => $this->kecamatan ?: '-',
            'websiteSekolah' => $this->websiteSekolah ?: 'writeboardedu.com',
            'telpSekolah' => $this->telpSekolah ?: '-',
            'emailSekolah' => $this->emailSekolah ?: '-',
            'tanggalPiagam' => $this->tanggalPiagam
                ? date('d F Y', strtotime($this->tanggalPiagam))
                : now()->translatedFormat('d F Y'),
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'piagam_peringkat_' . str_replace(' ', '_', strtolower($siswa->nama)) . '.pdf'
        );
    }

    public function render()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->find($this->siswaId);

        if ($siswa) {
            $nilaiRecords = Nilai::where('siswa_id', $siswa->id)->get();
            $this->jumlahMapel = $nilaiRecords->count();
            $this->totalNilaiAkhir = 0;

            if ($nilaiRecords->isNotEmpty()) {
                foreach ($nilaiRecords as $n) {
                    if ($n->nilai_harian !== null || $n->nilai_uts !== null || $n->nilai_uas !== null) {
                        $sumParts = ($n->nilai_harian ?? 0) + ($n->nilai_uts ?? 0) + ($n->nilai_uas ?? 0);
                        $nilaiAkhir = round($sumParts / 3);
                        $this->totalNilaiAkhir += $nilaiAkhir;
                    }
                }
            }
        }

        return view('livewire.peringkat-piagam', [
            'siswa' => $siswa,
            'peringkat' => $this->peringkat,
            'totalNilai' => $this->totalNilaiAkhir,
            'jumlahMapel' => $this->jumlahMapel,
        ]);
    }
}
