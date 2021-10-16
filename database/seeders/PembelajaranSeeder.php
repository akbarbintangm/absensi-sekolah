<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use App\Models\Pembelajaran;
use Illuminate\Database\Seeder;

class PembelajaranSeeder extends Seeder
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
                'pelajaran_id' => '1',
                'jadwal_id' => '1',
                'guru_id' => '12',
                // 'metode_belajar_id' => '1',
                'kelas_id' => '6',
            ],
        ];
        foreach ($jadwal as $jad) {
            Pembelajaran::create($jad);
        }
    }
}
