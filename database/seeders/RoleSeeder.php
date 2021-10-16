<?php

namespace Database\Seeders;

use App\Models\User;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'Guru',
            ],
            [
                'name' => 'Ortu',
            ],
            [
                'name' => 'Siswa',
            ],
        ];
        foreach($roles as $role){
            Role::create($role);
        }
    }
}
