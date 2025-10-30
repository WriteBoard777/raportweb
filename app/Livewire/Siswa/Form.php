<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class Form extends Component
{
    public $showForm = false;
    public $showDelete = false;

    public $siswaId;
    public $nisn;
    public $nis;
    public $nama;
    public $nama_pgl;
    public $jenis_kelamin;
    public $nama_orang_tua = [];

    protected $listeners = [
        'openForm' => 'open',
        'confirmDelete' => 'confirmDelete', // 🔹 Tambah listener baru
    ];

    // 🔹 Modal Create / Edit
    public function open($id = null)
    {
        $this->resetValidation();
        $this->reset([
            'nisn',
            'nis',
            'nama',
            'nama_pgl',
            'jenis_kelamin',
            'nama_orang_tua',
            'siswaId'
        ]);

        $this->showForm = true;

        if ($id) {
            $siswa = Siswa::find($id);
            if ($siswa) {
                $this->fill([
                    'siswaId' => $siswa->id,
                    'nisn' => $siswa->nisn,
                    'nis' => $siswa->nis,
                    'nama' => $siswa->nama,
                    'nama_pgl' => $siswa->nama_pgl,
                    'jenis_kelamin' => $siswa->jenis_kelamin,
                    // langsung isi array, karena Eloquent sudah cast otomatis
                    'nama_orang_tua' => $siswa->nama_orang_tua ?? [],
                ]);
            }
        }
    }

    // 🔹 Simpan (Create / Update)
    public function save()
    {
        $this->validate([
            'nisn' => 'required|unique:siswas,nisn,' . $this->siswaId,
            'nis' => 'required|unique:siswas,nis,' . $this->siswaId,
            'nama' => 'required',
            'nama_pgl' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        Siswa::updateOrCreate(
            ['id' => $this->siswaId],
            [
                'user_id' => Auth::id(),
                'nisn' => $this->nisn,
                'nis' => $this->nis,
                'nama' => $this->nama,
                'nama_pgl' => $this->nama_pgl,
                'jenis_kelamin' => $this->jenis_kelamin,
                // simpan array langsung, biarkan Eloquent yang encode ke JSON
                'nama_orang_tua' => $this->nama_orang_tua,
            ]
        );

        // Tutup modal
        $this->showForm = false;

        // Reset input
        $this->reset(['siswaId', 'nisn', 'nis', 'nama', 'nama_pgl', 'jenis_kelamin', 'nama_orang_tua']);

        // Kirim event ke Index
        $this->dispatch('siswaUpdated');
    }

    // 🔹 Modal Konfirmasi Delete
    public function confirmDelete($id = null)
    {
        if ($id) {
            Siswa::find($id);
        }
        $this->siswaId = $id;
        $this->showDelete = true;
    }

    // 🔹 Eksekusi Delete
    public function delete()
    {
        if ($this->siswaId) {
            Siswa::find($this->siswaId)?->delete();
            $this->dispatch('siswaUpdated');
        }

        // Tutup modal
        $this->reset(['showDelete', 'siswaId']);
    }

    public function render()
    {
        return view('livewire.siswa.form');
    }
}
