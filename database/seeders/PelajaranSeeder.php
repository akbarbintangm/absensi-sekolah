<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\SekolahUser;
use App\Models\User;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PelajaranSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $pelajaran = [
            [
                'nama' => 'Matematika',
                'deskripsi' => ''
            ],
            [
                'nama' => 'IPA',
                'deskripsi' => 'Ilmu Pengetahuan Alam'
            ],
            [
                'nama' => 'IPS',
                'deskripsi' => 'Ilmu Pengetahuan Sosial'
            ],
            [
                'nama' => 'PPKn',
                'deskripsi' => 'Pendidikan Pancasila dan Kewarganegaraan'
            ],
        ];
        foreach ($pelajaran as $pel) {
            Pelajaran::create($pel);
        }
    }
}
