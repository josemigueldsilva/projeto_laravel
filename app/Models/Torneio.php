<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torneio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'quantidade_times',
        'times',           // Lista dos times participantes em JSON
        'pontuacoes',      // JSON das pontuações dos times
        'user_id',         // ID do usuário que criou o torneio
    ];

    protected $casts = [
        'times' => 'array',
        'pontuacoes' => 'array',
    ];
}
