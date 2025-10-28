<?php

namespace App\Livewire\Ekstra;

use Livewire\Component;
use App\Models\Ekstrakurikuler;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $showForm = false;
    public $showDelete = false;

    public $ekstraId;
    public $nama_ekstrakurikuler;

    protected $listeners = [
        'openEkstraForm' => 'open',
        'confirmDeleteEkstra' => 'confirmDelete',
    ];

    // 🔹 Modal Create / Edit
    public function open($id = null)
    {
        $this->resetValidation();
        $this->reset(['ekstraId', 'nama_ekstrakurikuler']);

        $this->showForm = true;

        if ($id) {
            $ekstra = Ekstrakurikuler::find($id);
            if ($ekstra) {
                $this->fill([
                    'ekstraId' => $ekstra->id,
                    'nama_ekstrakurikuler' => $ekstra->nama_ekstrakurikuler,
                ]);
            }
        }
    }

    // 🔹 Simpan (Create / Update)
    public function save()
    {
        $this->validate([
            'nama_ekstrakurikuler' => 'required|string|min:3|max:255',
        ]);

        Ekstrakurikuler::updateOrCreate(
            ['id' => $this->ekstraId],
            [
                'user_id' => Auth::id(),
                'nama_ekstrakurikuler' => $this->nama_ekstrakurikuler,
            ]
        );

        $this->showForm = false;
        $this->reset(['ekstraId', 'nama_ekstrakurikuler']);

        $this->dispatch('ekstraUpdated');
    }

    // 🔹 Modal Konfirmasi Delete
    public function confirmDelete($id = null)
    {
        if ($id) {
            Ekstrakurikuler::find($id);
        }
        $this->ekstraId = $id;
        $this->showDelete = true;
    }

    // 🔹 Eksekusi Delete
    public function delete()
    {
        if ($this->ekstraId) {
            Ekstrakurikuler::find($this->ekstraId)?->delete();
            $this->dispatch('ekstraUpdated');
        }

        $this->reset(['showDelete', 'ekstraId']);
    }

    public function render()
    {
        return view('livewire.ekstra.form');
    }
}
