<?php

namespace App\Livewire\Mapel;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Mapel;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $showForm = false;

    public $mapelId; // digunakan saat edit aktif/tidak
    public $activeMapels = []; // array mapel_id yang dipilih

    public $mapels = []; // semua mapel dari database

    protected $listeners = [
        'openMapelForm' => 'open',
    ];

    public function mount()
    {
        // Ambil semua mapel dari database
        $this->mapels = Mapel::orderBy('nama_mapel')->get();
    }

    public function open()
    {
        $this->showForm = true;

        // Ambil mapel yang sudah aktif untuk user ini
        $this->activeMapels = DB::table('mapel_user')
            ->where('user_id', Auth::id())
            ->pluck('mapel_id')
            ->toArray();
    }

    public function save()
    {
        DB::transaction(function () {
            // Hapus dulu semua mapel_user untuk user ini
            DB::table('mapel_user')->where('user_id', Auth::id())->delete();

            // Insert mapel yang dipilih
            foreach ($this->activeMapels as $mapel_id) {
                DB::table('mapel_user')->insert([
                    'user_id' => Auth::id(),
                    'mapel_id' => $mapel_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        $this->showForm = false;
        $this->dispatch('mapelUpdated');
    }

    public function render()
    {
        return view('livewire.mapel.form');
    }
}
