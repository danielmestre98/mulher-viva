<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Judicializacao extends Model
{
    protected $table = "judicializacao";
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'municipio',
        'numero_processo',
        'data_processo',
    ];

    static function encryptPdf($pdfFile)
    {
        $encryptedFile = encrypt($pdfFile);
        return $encryptedFile;
    }

    static function decryptPdf($pdfFile)
    {
        $decryptedFile = decrypt($pdfFile);
        return $decryptedFile;
    }

    function municipios()
    {
        return $this->belongsTo(Municipio::class, "municipio", "id");
    }
}
