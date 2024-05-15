<?php

namespace App\Http\Controllers;

use App\Models\Beneficiarias;
use App\Models\ListasBeneficiarias;
use App\Models\Vagas;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    function index()
    {
        $mesReferencia = Carbon::now();
        //data de fechamento do sistema MUDAR EM CASO DE DATA DIFERENTE
        if (date("d") > 15) {
            $mesReferencia = $mesReferencia->addMonth();
        }
        $mesReferenciaDisplay = $mesReferencia->format("m/Y");
        $mesReferencia = $mesReferencia->format("Y-m");
        $municipio = Auth::user()->municipio;
        $lista = ListasBeneficiarias::where("mes_referencia", $mesReferencia)->where("municipio",  $municipio)->first();
        $alreadyApproved = false;
        if (!empty($lista)) {
            $alreadyApproved = true;
        }
        $jaAprovadas = Beneficiarias::where("status", 1)->where("municipio", $municipio)->get();
        $beneficiarias = Beneficiarias::whereIn("status", [5, 6])->where("municipio", $municipio)->orderBy("posicao", "ASC")->get();
        $vagas = Vagas::where("municipio", $municipio)->pluck("quantidade");
        $selecionadas = new Collection();
        for ($i = 0; $i < $vagas[0] - count($jaAprovadas) ?? 0; $i++) {
            $selecionadas->add($beneficiarias[$i]);
        }
        $listaCompleta = $selecionadas->merge($jaAprovadas);
        return view("cadastros.lista", ["beneficiarias" => $listaCompleta, "mesReferencia" => $mesReferenciaDisplay, "approved" => $alreadyApproved]);
    }

    function approveList()
    {
        $mesReferencia = Carbon::now();
        //data de fechamento do sistema MUDAR EM CASO DE DATA DIFERENTE
        if (date("d") > 15) {
            $mesReferencia = $mesReferencia->addMonth();
        }
        $mesReferencia = $mesReferencia->format("Y-m");
        $municipio = Auth::user()->municipio;
        $jaAprovadas = Beneficiarias::where("status", 1)->where("municipio", Auth::user()->municipio)->pluck("id")->toArray();
        $beneficiarias = Beneficiarias::whereIn("status", [5, 6])->where("municipio", Auth::user()->municipio)->orderBy("posicao", "ASC")->pluck("id");
        $vagas = Vagas::where("municipio", $municipio)->pluck("quantidade");
        $selecionadas = [];
        for ($i = 0; $i < $vagas[0] - count($jaAprovadas) ?? 0; $i++) {
            $selecionadas[] = $beneficiarias[$i];
            $collectionBenef = Beneficiarias::find($beneficiarias[$i]);
            $collectionBenef->status = 6;
            $collectionBenef->save();
        }
        $listaCompleta = array_merge($jaAprovadas, $selecionadas);
        $lista = ListasBeneficiarias::where("mes_referencia", $mesReferencia)->where("municipio", Auth::user()->municipio)->first();

        if (!isset($lista)) {
            $lista = new ListasBeneficiarias;
            $lista->mes_referencia = $mesReferencia;
            $lista->municipio = Auth::user()->municipio;
            $lista->created_by = Auth::user()->id;
            $lista->save();
        }
        $lista->beneficiarias()->sync($listaCompleta);
        return true;
    }
}
