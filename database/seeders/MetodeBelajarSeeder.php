<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\MetodeBelajar;
use App\Models\SekolahUser;
use App\Models\User;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MetodeBelajarSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $metode = [
            [
                'nama' => 'Tatap Muka',
            ],
            [
                'nama' => 'Online',
            ],
            [
                'nama' => 'Studi Lapangan',
            ],
        ];
        foreach ($metode as $met) {
            MetodeBelajar::create($met);
        }
    }
}
