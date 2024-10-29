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
        'times',
        'formato',
        'times_por_grupo',
        'resultados', // Adicione esta linha
    ];
    
}
