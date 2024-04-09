<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drads extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nome',
        'bairro',
        'endereco',
        'telefone',
        'cep',
        'diretor',
        'id_municipio',
        'cod_uge',
    ];
}
