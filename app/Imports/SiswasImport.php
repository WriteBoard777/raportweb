<?php

namespace App\Imports;

use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswasImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        return new Siswa([
            'user_id' => $this->userId,
            'nisn' => $row['nisn'],
            'nis' => $row['nis'],
            'nama' => $row['nama'],
            'nama_pgl' => $row['nama_pgl'] ?? $row['nama_panggilan'] ?? '',
            'jenis_kelamin' => strtoupper($row['jenis_kelamin']) == 'L' ? 'L' : 'P',
            'nama_orang_tua' => [
                $row['nama_ayah'] ?? '',
                $row['nama_ibu'] ?? '',
            ],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nisn' => 'required|unique:siswas,nisn',
            '*.nis' => 'required|unique:siswas,nis',
            '*.nama' => 'required',
            '*.jenis_kelamin' => 'required|in:L,P,l,p',
        ];
    }
}
