<?php

namespace App\Livewire\DetailUser;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailUser;

class Index extends Component
{
    public string $name = '';
    public string $nip = '';

    public string $npsn = '';
    public string $asal_sekolah = '';
    public string $jenis_sekolah = '';
    public string $nama_kepala_sekolah = '';
    public string $nip_kepala_sekolah = '';
    public string $email_sekolah = '';
    public string $telp_sekolah = '';
    public string $web_sekolah = '';

    public string $kabupaten = '';
    public string $kecamatan = '';
    public string $alamat = '';

    public string $kelas = '';
    public string $tahun_ajaran = '';
    public string $semester = '';

    /**
     * Saat jenis sekolah berubah, perbarui label NIP/NIY
     */
    public function updatedJenisSekolah(): void
    {
        $this->dispatch('$refresh');
    }

    /**
     * Load data detail user
     */
    public function mount(): void
    {
        $user = Auth::user();
        $detail = $user->detail; // relasi hasOne

        if ($detail) {
            $this->name = $detail->name ?? '';
            $this->nip = $detail->nip ?? '';

            $this->npsn = $detail->npsn ?? '';
            $this->asal_sekolah = $detail->asal_sekolah ?? '';
            $this->jenis_sekolah = $detail->jenis_sekolah ?? '';
            $this->nama_kepala_sekolah = $detail->nama_kepala_sekolah ?? '';
            $this->nip_kepala_sekolah = $detail->nip_kepala_sekolah ?? '';
            $this->email_sekolah = $detail->email_sekolah ?? '';
            $this->telp_sekolah = $detail->telp_sekolah ?? '';
            $this->web_sekolah = $detail->web_sekolah ?? '';

            $this->kabupaten = $detail->kabupaten ?? '';
            $this->kecamatan = $detail->kecamatan ?? '';
            $this->alamat = $detail->alamat ?? '';

            $this->kelas = $detail->kelas ?? '';
            $this->tahun_ajaran = $detail->tahun_ajaran ?? '';
            $this->semester = $detail->semester ?? '';
        }
    }

    /**
     * Validasi dan update data detail user
     */
    public function updateDetailInformation(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:255'],

            'npsn' => ['required', 'string', 'max:255'],
            'asal_sekolah' => ['required', 'string', 'max:255'],
            'jenis_sekolah' => ['required', 'in:Negeri,Swasta'],
            'nama_kepala_sekolah' => ['required', 'string', 'max:255'],
            'nip_kepala_sekolah' => ['nullable', 'string', 'max:255'],
            'email_sekolah' => ['nullable', 'string', 'max:255'],
            'telp_sekolah' => ['nullable', 'string', 'max:255'],
            'web_sekolah' => ['nullable', 'string', 'max:255'],

            'kabupaten' => ['required', 'string', 'max:500'],
            'kecamatan' => ['required', 'string', 'max:500'],
            'alamat' => ['required', 'string', 'max:500'],

            'kelas' => ['required', 'string', 'max:255'],
            'tahun_ajaran' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();

        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        $this->dispatch('detail-updated');
    }

    /**
     * Label dinamis untuk NIP/NIY
     */
    public function getNipLabelProperty(): string
    {
        return $this->jenis_sekolah === 'Swasta' ? 'NIY' : 'NIP';
    }

    public function getNipKepsekLabelProperty(): string
    {
        return $this->jenis_sekolah === 'Swasta' ? 'NIY Kepala Sekolah' : 'NIP Kepala Sekolah';
    }

    public function render()
    {
        return view('livewire.detail-user');
    }
}
