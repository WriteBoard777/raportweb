<?php

namespace App\Livewire\Tp;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Tp;
use App\Models\Mapel;

class Form extends Component
{
    public $showForm = false;
    public $tpId;
    public $mapel_id;
    public $deskripsis = [];

    public $mapels = [];

    protected $listeners = ['openTpForm' => 'open'];

    public function mount()
    {
        $this->loadActiveMapels();
    }

    public function loadActiveMapels()
    {
        $this->mapels = Mapel::whereIn('id', function ($query) {
            $query->select('mapel_id')
                ->from('mapel_user')
                ->where('user_id', Auth::id());
        })->orderBy('nama_mapel')->get();
    }

    public function open($id = null)
    {
        $this->resetValidation();
        $this->reset(['mapel_id', 'deskripsis', 'tpId']);
        $this->showForm = true;

        $this->loadActiveMapels();

        if ($id) {
            $tp = Tp::find($id);
            if ($tp) {
                $this->fill([
                    'tpId' => $tp->id,
                    'mapel_id' => $tp->mapel_id,
                    'deskripsis' => json_decode($tp->deskripsi ?? '[]', true),
                ]);
            }
        }
    }

    public function addDeskripsi()
    {
        $this->deskripsis[] = '';
    }

    public function removeDeskripsi($index)
    {
        unset($this->deskripsis[$index]);
        $this->deskripsis = array_values($this->deskripsis);
    }

    public function save()
    {
        $this->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'deskripsis' => 'required|array|min:1',
        ]);

        Tp::updateOrCreate(
            ['id' => $this->tpId],
            [
                'user_id' => Auth::id(),
                'mapel_id' => $this->mapel_id,
                'deskripsi' => json_encode($this->deskripsis),
            ]
        );

        $this->showForm = false;
        $this->reset(['tpId', 'mapel_id', 'deskripsis']);
        $this->dispatch('tpUpdated');
    }

    public function render()
    {
        return view('livewire.tp.form');
    }
}
