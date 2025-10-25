<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public string $name = '';
    public string $nip = '';
    public string $email = '';
    public string $npsn = '';
    public string $asal_sekolah = '';
    public string $jenis_sekolah = '';
    public string $nama_kepala_sekolah = '';
    public string $nip_kepala_sekolah = '';
    public string $kelas = '';
    public string $alamat = '';
    public string $tahun_ajaran = '';
    public string $semester = '';

    /**
     * Saat jenis sekolah berubah, reset field NIP/NIY agar sesuai konteks
     */
    public function updatedJenisSekolah(): void
    {
        // Tidak perlu reset nilai, cukup trigger re-render agar label berubah
        $this->dispatch('$refresh');
    }

    /**
     * Load data user ke komponen
     */
    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->nip = $user->nip;
        $this->email = $user->email;
        $this->npsn = $user->npsn;
        $this->asal_sekolah = $user->asal_sekolah;
        $this->jenis_sekolah = $user->jenis_sekolah;
        $this->nama_kepala_sekolah = $user->nama_kepala_sekolah;
        $this->nip_kepala_sekolah = $user->nip_kepala_sekolah;
        $this->kelas = $user->kelas;
        $this->alamat = $user->alamat;
        $this->tahun_ajaran = $user->tahun_ajaran;
        $this->semester = $user->semester;
    }

    /**
     * Validasi & update profil
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:255'], // ubah jadi nullable
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'npsn' => ['required', 'string', 'max:255'],
            'asal_sekolah' => ['required', 'string', 'max:255'],
            'jenis_sekolah' => ['required', 'in:Negeri,Swasta'],
            'nama_kepala_sekolah' => ['required', 'string', 'max:255'],
            'nip_kepala_sekolah' => ['nullable', 'string', 'max:255'], // ubah jadi nullable juga
            'kelas' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:500'],
            'tahun_ajaran' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:255'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }


    /**
     * Kirim ulang verifikasi email
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Getter dinamis untuk label NIP/NIY sesuai jenis sekolah
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
        return view('livewire.settings.profile');
    }
}
