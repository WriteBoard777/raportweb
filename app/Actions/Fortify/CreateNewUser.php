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
            'nip' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],

            'npsn' => ['required', 'string', 'max:255'],
            'asal_sekolah' => ['required', 'string', 'max:255'],
            'jenis_sekolah' => 'required|in:Negeri,Swasta',
            'nama_kepala_sekolah' => ['required', 'string', 'max:255'],
            'nip_kepala_sekolah' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:500'],
            'tahun_ajaran' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:255'],

            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'nip' => $input['nip'],
            'email' => $input['email'],
            'password' => $input['password'],
            'npsn' => $input['npsn'],
            'asal_sekolah' => $input['asal_sekolah'],
            'jenis_sekolah' => $input['jenis_sekolah'],
            'nama_kepala_sekolah' => $input['nama_kepala_sekolah'],
            'nip_kepala_sekolah' => $input['nip_kepala_sekolah'],
            'kelas' => $input['kelas'],
            'alamat' => $input['alamat'],
            'tahun_ajaran' => $input['tahun_ajaran'],
            'semester' => $input['semester'],
        ]);
    }
}
