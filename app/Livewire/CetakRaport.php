<?php

namespace App\Livewire;

use App\Models\Tp;
use App\Models\Absen;
use App\Models\Nilai;
use App\Models\Siswa;
use Livewire\Component;
use App\Models\NilaiEkstra;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CetakRaport extends Component
{
    public $siswaId;
    public $tanggalCetak;
    public $namaOrtuTerpilih;

    // Tambahkan dua ini agar Livewire mengenali properti yang dipakai wire:model
    public $deskripsiAtas = [];
    public $deskripsiBawah = [];

    public function mount($siswaId)
    {
        $this->siswaId = $siswaId;
        $this->tanggalCetak = now()->toDateString();
        $this->namaOrtuTerpilih = null;

        // Pastikan array kosong agar tidak error di awal render
        $this->deskripsiAtas = [];
        $this->deskripsiBawah = [];
    }

    public function exportPdf()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->findOrFail($this->siswaId);

        $nilai = Nilai::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->get();

        $nilaiEkstra = NilaiEkstra::with('ekstrakurikuler')
            ->where('siswa_id', $siswa->id)
            ->get();

        $absen = Absen::where('siswa_id', $siswa->id)->first();

        // Kirim juga deskripsi atas & bawah ke view PDF
        $pdf = Pdf::loadView('pdf.raport', [
            'user' => $user,
            'siswa' => $siswa,
            'nilai' => $nilai,
            'nilaiEkstra' => $nilaiEkstra,
            'absen' => $absen,
            'tanggalCetak' => $this->tanggalCetak,
            'namaOrtu' => $this->namaOrtuTerpilih,
            'deskripsiAtas' => $this->deskripsiAtas,
            'deskripsiBawah' => $this->deskripsiBawah,
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'raport_' . str_replace(' ', '_', strtolower($siswa->nama)) . '.pdf'
        );
    }

    public function render()
    {
        $user = Auth::user();

        $siswa = Siswa::where('user_id', $user->id)->find($this->siswaId);

        $nilai = Nilai::with('mapel')
            ->where('siswa_id', $this->siswaId)
            ->get();

        $nilaiEkstra = NilaiEkstra::with('ekstrakurikuler')
            ->where('siswa_id', $this->siswaId)
            ->get();

        $absen = Absen::where('siswa_id', $this->siswaId)->first();

        // Ambil semua TP milik guru/user yang sedang login
        $tps = Tp::where('user_id', $user->id)
            ->get()
            ->groupBy('mapel_id')
            ->map(function ($group) {
                return $group->map(function ($tp) {
                    // Coba decode JSON
                    $decoded = json_decode($tp->deskripsi, true);

                    if (is_array($decoded)) {
                        // Jika valid JSON, pakai hasil decode
                        $tp->deskripsi_list = $decoded;
                    } else {
                        // Jika bukan JSON, pecah berdasarkan koma atau baris baru
                        $tp->deskripsi_list = preg_split('/\r\n|\r|\n|,/', $tp->deskripsi);
                    }

                    // Bersihkan spasi berlebih
                    $tp->deskripsi_list = array_map('trim', $tp->deskripsi_list);

                    // Hapus elemen kosong
                    $tp->deskripsi_list = array_filter($tp->deskripsi_list);

                    return $tp;
                });
            });



        return view('livewire.cetak-raport', [
            'siswa' => $siswa,
            'nilai' => $nilai,
            'nilaiEkstra' => $nilaiEkstra,
            'absen' => $absen,
            'tps' => $tps,
        ]);
    }
}
