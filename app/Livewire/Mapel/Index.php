<?php

namespace App\Livewire\Mapel;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Mapel;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $search = '';

    protected $listeners = [
        'mapelUpdated' => 'refreshData',
    ];

    public function refreshData()
    {
        // kosongkan, Livewire otomatis rerender
    }

    public function render()
    {
        $userId = Auth::id();

        // Ambil mapel dari seeder, dan cek apakah user aktifkan
        $mapels = Mapel::where('nama_mapel', 'like', "%{$this->search}%")
            ->orderBy('nama_mapel')
            ->get()
            ->map(function ($mapel) use ($userId) {
                $mapel->is_active = DB::table('mapel_user')
                    ->where('user_id', $userId)
                    ->where('mapel_id', $mapel->id)
                    ->exists();
                return $mapel;
            });

        return view('livewire.mapel.index', compact('mapels'));
    }
}
