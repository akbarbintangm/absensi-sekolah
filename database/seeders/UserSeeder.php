<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $guru = [
            'name' => 'Guru',
            // 'username' => 'admin',
            'email' => 'guru@guru.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        User::create($guru)->assignRole('Guru');
        $guru = [
            'name' => 'Guru2',
            // 'username' => 'admin',
            'email' => 'guru2@guru2.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        User::create($guru)->assignRole('Guru');

        $siswa = [
            'name' => 'Siswa1',
            // 'username' => 'admin',
            'email' => 'siswa@siswa.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        User::create($siswa)->assignRole('Siswa');
        $siswa = [
            'name' => 'Siswa2',
            // 'username' => 'admin',
            'email' => 'siswa2@siswa2.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        User::create($siswa)->assignRole('Siswa');

        $ortu = [
            'name' => 'Orang Tua',
            // 'username' => 'admin',
            'email' => 'ortu@ortu.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        User::create($ortu)->assignRole('Ortu');
    }
}
