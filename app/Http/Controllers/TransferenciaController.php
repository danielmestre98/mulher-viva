<?php

namespace App\Http\Controllers;

use App\Models\Beneficiarias;
use App\Models\Vagas;
use Illuminate\Http\Request;

class TransferenciaController extends Controller
{
    function index(Request $request)
    {
        $vagasDisponiveis = [];
        $action = $request->get('success');
        $vagas = Vagas::with("municipios")->where("quantidade", ">", 0)->get();
        $allMunicipios = Vagas::with("municipios")->get();
        for ($i = 0; $i < count($vagas); $i++) {
            $vagasDisponiveis[$i] = ["municipio" => $vagas[$i]->municipios->nome, "quantidade" => $vagas[$i]->quantidade, "id" => $vagas[$i]->id];
            $beneficiarias = Beneficiarias::where("municipio", "=", $vagas[$i]->municipio)->whereIn("status", [1, 2, 5, 6])->count();
            if ($beneficiarias > 0)
                $vagasDisponiveis[$i]["quantidade"] =  $vagasDisponiveis[$i]["quantidade"] - $beneficiarias;
        }
        // dd($vagasDisponiveis);
        if ($action) {
            return view("operacoes.transferenciaVagas", ["vagas" => $vagasDisponiveis, "allMunicipios" => $allMunicipios, "action" => "success"]);
        }
        return view("operacoes.transferenciaVagas", ["vagas" => $vagasDisponiveis, "allMunicipios" => $allMunicipios]);
    }

    function efetuarTransferencia(Request $request)
    {
        $qtdTransferir = 0;
        $origens = $request->origens;
        $destino = $request->destino;

        foreach ($origens as $key => $value) {
            $qtdTransferir += $value["qtd"];
            $vagasOrigem = Vagas::find($key);
            $vagasOrigem->quantidade = $vagasOrigem->quantidade - $value["qtd"];
            $vagasOrigem->save();
        }
        $vagasDestino = Vagas::find($destino);
        $vagasDestino->quantidade = $vagasDestino->quantidade + $qtdTransferir;
        $vagasDestino->save();
        return true;
    }
}
