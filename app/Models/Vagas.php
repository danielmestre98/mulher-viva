<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vagas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'municipio',
        'vagas',
    ];

    function municipios()
    {
        return $this->hasOne(Municipio::class, "id", "municipio");
    }
}
