<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Sekolah::factory(10)->create();
        \App\Models\User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            SekolahUserSeeder::class,
            KelasSeeder::class,
            PelajaranSeeder::class,
            MetodeBelajarSeeder::class,
            KelasUserSeeder::class,
            JadwalSeeder::class,
            PembelajaranSeeder::class,
        ]);
    }
}
