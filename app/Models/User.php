<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use CrudTrait; // <----- this
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNamaAttribute($value)
    {
        $roleNames = '';
        $roles = $this->getRoleNames()->toArray();
        foreach ($roles as $key => $rName) {
            $roleNames .= $rName;
            if ($key !== array_key_last($roles)) {
                $roleNames .= ', ';
            }
        }
        return $this->name . ' (' . $roleNames . ')';
    }

    public function identifiableAttribute()
    {
        // process stuff here
        return 'nama';
    }


    public function sekolah()
    {
        // return $this->belongsToMany(Role::class, 'role_user');
        // "role_user" is table name
        // OR if we have model RoleUser, then we can use class
        // instead of table name role_user
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'id');
    }


    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_users');
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function ortu()
    {
        return $this->belongsTo(User::class, 'ortu_id');
    }

    public function anak()
    {
        return $this->hasMany(User::class, 'ortu_id');
    }
}
