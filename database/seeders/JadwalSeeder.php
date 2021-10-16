<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $jadwal = [
            [
                'hari' => 'senin',
                'mulai' => '06:45:00',
                'berakhir' => '08:15:00',
            ],
            [
                'hari' => 'senin',
                'mulai' => '08:15:00',
                'berakhir' => '09:45:00',
            ],
        ];
        foreach ($jadwal as $jad) {
            Jadwal::create($jad);
        }
    }
}
