<?php

namespace App\Models;

use App\Traits\HasRole;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Auditable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class User extends Authenticatable implements Transformable
{
    use Notifiable, HasApiTokens, SoftDeletes, TransformableTrait, HasRole, Auditable;
    const INATIVO = "inativo";
    const ATIVO = "ativo";
    const BLOQUEADO = "bloqueado";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',  'password','email_alternativo', 'sexo', 'imagem', 'chk_newsletter', 'status'
    ];

    public function findForPassport($username) {
        $return = $this->where('email', $username)->first();
        if($return->status != self::ATIVO){
            return;
        }
        return $return;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public static $_SEXO = [
            1=>'masculino',
            2=>'feminino'
        ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user', 'user_id', 'permission_id');
    }

    public function endereco()
    {
        return $this->morphOne(Endereco::class,'enderecotable');
    }

    public function telefones()
    {
        return $this->morphMany(Telefone::class,'telefonetable');
    }

    public function return_roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

}
