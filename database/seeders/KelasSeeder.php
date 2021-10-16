<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\SekolahUser;
use App\Models\User;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $kelas = [
            [
                'tingkatan' => '10',
                'jenis' => 'A'
            ],
            [
                'tingkatan' => '10',
                'jenis' => 'B'
            ],
            [
                'tingkatan' => '11',
                'jenis' => 'A'
            ],
            [
                'tingkatan' => '11',
                'jenis' => 'B'
            ],
            [
                'tingkatan' => '12',
                'jenis' => 'A'
            ],
            [
                'tingkatan' => '12',
                'jenis' => 'B'
            ],
        ];
        foreach ($kelas as $kel) {
            Kelas::create($kel);
        }
    }
}
