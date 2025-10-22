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

    public string $email = '';

    public string $kelas = '';

    public string $asal_sekolah = '';

    public string $nama_kepala_sekolah = '';

    public string $npsn = '';

    public string $semester = '';

    public string $tahun_ajaran = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->kelas = Auth::user()->kelas;
        $this->asal_sekolah = Auth::user()->asal_sekolah;
        $this->nama_kepala_sekolah = Auth::user()->nama_kepala_sekolah;
        $this->npsn = Auth::user()->npsn;
        $this->semester = Auth::user()->semester;
        $this->tahun_ajaran = Auth::user()->tahun_ajaran;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'kelas' => ['required', 'string', 'max:255'],
            'asal_sekolah' => ['required', 'string', 'max:255'],
            'nama_kepala_sekolah' => ['required', 'string', 'max:255'],
            'npsn' => ['required', 'string', 'max:255'],
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
     * Send an email verification notification to the current user.
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
}
