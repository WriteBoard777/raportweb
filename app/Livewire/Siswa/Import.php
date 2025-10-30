<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel; // ✅ Tambahkan ini
use App\Imports\SiswasImport;

class Import extends Component
{
    use WithFileUploads;

    public $file;
    public $showImport = false;

    protected $rules = [
        'file' => 'required|mimes:xlsx,csv,xls|max:2048',
    ];

    protected $listeners = ['openImport' => 'openModal'];

    public function openModal()
    {
        $this->reset('file');
        $this->showImport = true;
    }

    public function import()
    {
        $this->validate();

        try {
            // ✅ Gunakan facade Excel, bukan method langsung
            Excel::import(new SiswasImport(Auth::id()), $this->file->getRealPath());

            $this->reset('file');
            $this->dispatch('siswaUpdated');
            $this->showImport = false;

            session()->flash('success', 'Data siswa berhasil diimpor!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.siswa.import');
    }
}
