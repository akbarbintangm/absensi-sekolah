<?php

namespace Database\Seeders;

use App\Models\SekolahUser;
use App\Models\User;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SekolahUserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        // $cons = [
        //     [
        //         'user' => User::find(1),
        //         'sekolah_id' => '1',
        //     ],
        //     [
        //         'user' => User::find(2),
        //         'sekolah_id' => '1',
        //     ],
        //     [
        //         'user' => User::find(3),
        //         'sekolah_id' => '1',
        //     ],
        //     [
        //         'user' => User::find(4),
        //         'sekolah_id' => '1',
        //     ],
        // ];
        // foreach ($cons as $con) {
        //     $con['user']->sekolah_id = $con['sekolah_id'];
        //     $con['user']->save();
        // }
    }
}
