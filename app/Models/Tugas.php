<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tugas';
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

    public function getJenisAttribute($value)
    {
        if ($this->tugas) {

            return 'Tugas';
        } else {
            return 'Materi';
        }
    }

    public function pengumpulanUrl($crud = false)
    {
        return '<a class="btn btn-sm btn-link" href="' . backpack_url() . '/pengumpulan-tugas/create?tugas=' . urlencode($this->id) . '"><i class="las la-pen"></i></i> Kumpulkan Tugas</a>';
    }

    public function pengumpulanStatus($crud = false)
    {
        if ($this->pengumpulanTugas != null) {
            return '<div class="btn btn-success">Sudah</div>';
        } else {
            return '<div class="btn btn-danger">Belum</div>';
        }
    }

    public function editPengumpulanUrl($crud = false)
    {
        $pengumpulan = $this->pengumpulanTugas->id;
        return '<a class="btn btn-sm btn-link" href="' . backpack_url() . '/pengumpulan-tugas/' . $pengumpulan . '/edit"><i class="las la-pen"></i></i> Edit Tugas</a>';
    }

    public function getMetodeUrl()
    {
        $buttons = '<div class="d-flex">';

        if ($this->membaca != null) {
            $buttons .= '<a class="btn btn-primary mx-2" href="' . url($this->membaca) . '" target="_blank"><i class="las la-book-open"></i> Baca</a>';
        }
        if ($this->mendengar != null) {
            $buttons .= '<a class="btn btn-primary mx-2" href="' . url($this->mendengar) . '" target="_blank"><i class="las la-headphones"></i> Dengarkan</a>';
        }
        if ($this->menonton != null) {
            $buttons .= '<a class="btn btn-primary mx-2" href="' . url($this->menonton) . '" target="_blank"><i class="las la-video"></i> Tonton</a>';
        }
        $buttons .= '</div>';
        return $buttons;
        // return '<a class="btn btn-primary" href="' . url($this->membaca) . '" target="_blank">Baca</a>';
    }
    public function getMendengarUrl()
    {
        return '<a href="' . url($this->mendengar) . '" target="_blank">Dengarkan</a>';
    }
    public function getMenontonUrl()
    {
        return '<a href="' . url($this->menonton) . '" target="_blank">Tonton</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function pembelajaran()
    {
        return $this->belongsTo(Pembelajaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengumpulanTugas()
    {
        return $this->hasOne(PengumpulanTugas::class);
    }

    public function metodeBelajar()
    {
        return $this->belongsTo(MetodeBelajar::class);
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
