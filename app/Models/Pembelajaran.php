<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Pembelajaran extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'pembelajaran';
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

    public function getNamaAttribute($value)
    {
        return $this->pelajaran->nama . ' ' . $this->kelas->nama;
    }

    public function identifiableAttribute()
    {
        return 'nama';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function pelajaran()
    {
        return $this->belongsTo(Pelajaran::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class);
    }

    // public function metodeBelajar()
    // {
    //     return $this->belongsTo(MetodeBelajar::class);
    // }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function siswa()
    {
        $kelas = $this->kelas;
        $users = $kelas->users;
        return $users;
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
