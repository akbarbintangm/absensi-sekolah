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

class KelasUserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user) {
            $user->kelas()->attach(1);
        }
    }
}
