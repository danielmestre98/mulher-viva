<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ListasBeneficiarias extends Model
{
    use HasFactory;
    protected $table = "listas_beneficiarias";
    protected $fillable = [
        'mes_referencia',
        'created_by',
    ];


    public static function checkList($municipio, $lista)
    {
        $mesReferencia = Carbon::now();
        if (date("d") > 15) {
            $mesReferencia = $mesReferencia->addMonth();
        }
        $mesReferencia = $mesReferencia->format("Y-m");
        $listaAntiga = ListasBeneficiarias::where("mes_referencia", $mesReferencia)->where("municipio", $municipio)->first();
        if (empty($listaAntiga)) return;

        $vagas = Vagas::where("municipio", $municipio)->pluck("quantidade");
        $selecionadas = new Collection();
        for ($i = 0; $i < $vagas[0] ?? 0; $i++) {
            $selecionadas->add($lista[$i]);
        }
        $listaAntigaData = $listaAntiga->beneficiarias()->get()->toArray();
        foreach ($listaAntigaData as $key => $value) {
            unset($value['pivot']);
            $listaAntigaData[$key] = $value;
        }
        if ($selecionadas->toArray() != $listaAntigaData) {
            $listaAntiga->delete();
            Beneficiarias::where("municipio", $municipio)->where("status", 6)->update([
                "status" => 5
            ]);
        }
    }

    public function beneficiarias()
    {
        return $this->belongsToMany(Beneficiarias::class, 'lista_beneficiaria_relation', "listas", 'beneficiarias');
    }

    public function municipios()
    {
        return $this->belongsTo(Municipio::class, "municipio", "id");
    }

    public function users()
    {
        return $this->belongsTo(User::class, "created_by", "id");
    }
}
