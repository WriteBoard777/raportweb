<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

// Settings bawaan
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;

// Komponen CRUD baru
use App\Livewire\Siswa\Index as SiswaIndex;
use App\Livewire\Mapel\Index as MapelIndex;
use App\Livewire\Tp\Index as TpIndex;
use App\Livewire\Nilai\Index as NilaiIndex;
use App\Livewire\Leger; // <-- Tambahkan komponen Leger

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {

    // Dashboard utama
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // 🔹 ROUTES CRUD (Livewire Pages)
    Route::get('siswa', SiswaIndex::class)->name('siswa.index');
    Route::get('mapel', MapelIndex::class)->name('mapel.index');
    Route::get('tp', TpIndex::class)->name('tp.index');
    Route::get('nilai', NilaiIndex::class)->name('nilai.index');

    // 🔹 ROUTE Leger Nilai
    Route::get('leger', Leger::class)->name('leger.index');

    // 🔹 ROUTES SETTINGS bawaan StarterKit
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
