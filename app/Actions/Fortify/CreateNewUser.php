<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'kelas' => ['required', 'string', 'max:255'],
            'asal_sekolah' => ['required', 'string', 'max:255'],
            'nama_kepala_sekolah' => ['required', 'string', 'max:255'],
            'npsn' => ['required', 'string', 'max:255'],
            'tahun_ajaran' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'kelas' => $input['kelas'],
            'asal_sekolah' => $input['asal_sekolah'],
            'nama_kepala_sekolah' => $input['nama_kepala_sekolah'],
            'npsn' => $input['npsn'],
            'tahun_ajaran' => $input['tahun_ajaran'],
            'semester' => $input['semester'],
        ]);
    }
}
