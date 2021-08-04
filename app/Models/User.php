<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public const TIPO_ENUM = [
        "admin" => "admin",
        "gerente" => "gerente",
        "colaborador" => "colaborador",
        "secretaria" => "secretaria",
        "enfermeira" => "enfermeira",
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pontos()
    {
        return $this->belongsToMany(PostoVacinacao::class, 'posto_vacinacao_user');
    }
}
