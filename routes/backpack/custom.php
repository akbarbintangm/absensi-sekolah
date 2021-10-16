<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('sekolah', 'SekolahCrudController');
    Route::crud('pembelajaran', 'PembelajaranCrudController');
    // Route::crud('metode-belajar', 'MetodeBelajarCrudController');
    Route::crud('tugas', 'TugasCrudController');
    Route::crud('kelas', 'KelasCrudController');
    Route::crud('nilai', 'NilaiCrudController');
    // Route::crud('rapot', 'RapotCrudController');
    Route::crud('jadwal', 'JadwalCrudController');
    Route::crud('pelajaran', 'PelajaranCrudController');
    Route::crud('pengumpulan-tugas', 'PengumpulanTugasCrudController');
}); // this should be the absolute last line of this file
