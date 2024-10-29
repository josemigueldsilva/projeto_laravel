<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements AuthenticatableContract
{
    use Notifiable;

    protected $table = 'admins'; // se o nome da tabela for diferente, defina aqui
    protected $fillable = ['nome', 'email', 'senha']; // campos que podem ser preenchidos
    protected $hidden = ['senha', 'remember_token']; // campos que devem ser ocultos
}
