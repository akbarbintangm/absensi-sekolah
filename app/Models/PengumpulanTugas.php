<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'pengumpulan_tugas';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function nilaiUrl($crud = false)
    {
        return '<a class="btn btn-sm btn-link" href="' . backpack_url() . '/nilai/create?pengumpulan_tugas=' . urlencode($this->id) . '"><i class="lar la-star"></i></i> Beri Nilai</a>';
    }

    public function editNilaiUrl($crud = false)
    {
        $nilai = $this->nilai;
        return '<a class="btn btn-sm btn-link" href="' . backpack_url() . '/nilai/' . $nilai->id . '/edit"><i class="las la-star"></i></i> Edit Nilai</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
