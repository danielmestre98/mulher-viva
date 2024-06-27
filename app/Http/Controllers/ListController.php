<?php

namespace App\Http\Controllers;

use App\Models\Beneficiarias;
use App\Models\Drads;
use App\Models\ListasBeneficiarias;
use App\Models\Log;
use App\Models\Municipio;
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
        $jaAprovadas = Beneficiarias::whereIn("status", [1, 8])->where("municipio", $municipio)->get();
        $beneficiarias = Beneficiarias::whereIn("status", [5, 6])->where("municipio", $municipio)->orderBy("posicao", "ASC")->get();
        $vagas = Vagas::where("municipio", $municipio)->pluck("quantidade");
        $selecionadas = new Collection();
        // dd(count($jaAprovadas));
        if (empty($jaAprovadas) && empty($beneficiarias)) {
            return view("cadastros.lista", ["beneficiarias" => [], "mesReferencia" => $mesReferenciaDisplay, "approved" => false]);
        }
        for ($i = 0; $i < $vagas[0] - count($jaAprovadas) ?? 0; $i++) {
            if (isset($beneficiarias[$i]))
                $selecionadas->add($beneficiarias[$i]);
        }
        $listaCompleta = $selecionadas->merge($jaAprovadas);
        return view("cadastros.lista", ["beneficiarias" => $listaCompleta, "mesReferencia" => $mesReferenciaDisplay, "approved" => $alreadyApproved]);
    }

    function listAll()
    {
        $drads = Drads::orderBy("nome", "ASC")->get();
        $municipios = Municipio::orderBy("nome", "ASC")->get();
        $mesesReferencia = ListasBeneficiarias::select("mes_referencia")->groupBy('mes_referencia')->get();
        $lista = ListasBeneficiarias::all();
        return view("cadastros.listas", ["referencias" => $mesesReferencia, "drads" => $drads, "municipios" => $municipios, "lista" => $lista]);
    }

    function listFilter(Request $request)
    {
        $drads = Drads::orderBy("nome", "ASC")->get();
        $municipios = Municipio::orderBy("nome", "ASC")->get();
        $mesesReferencia = ListasBeneficiarias::select("mes_referencia")->groupBy('mes_referencia')->get();
        $listaBeneficiarias = ListasBeneficiarias::query();
        if (!empty($request->municipio_filtro) || !empty($request->drads_filtro)) {
            $municipio = Municipio::where("drads_id", $request->drads_filtro)->orWhere("id", $request->municipio_filtro)->pluck("id");
            $listaBeneficiarias = $listaBeneficiarias->whereIn("municipio", $municipio);
        }
        if (!empty($request->mesReferencia)) {
            $listaBeneficiarias = $listaBeneficiarias->where("mes_referencia", $request->mesReferencia);
        }

        $lista = $listaBeneficiarias->get();
        return view("cadastros.listas", ["referencias" => $mesesReferencia, "drads" => $drads, "municipios" => $municipios, "lista" => $lista, "filtros" => [
            "drads" => $request->drads_filtro,
            "municipio" => $request->municipio_filtro,
            "mesReferencia" => $request->mesReferencia,
        ]]);
    }

    function getBeneficiarias($listId)
    {
        $lista = ListasBeneficiarias::with(["municipios", "users", "beneficiarias.statusCodes"])->find($listId);
        $lista->beneficiarias;
        return response()->json(["lista" => $lista]);
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
        $jaAprovadas = Beneficiarias::whereIn("status", [1, 8])->where("municipio", Auth::user()->municipio)->pluck("id")->toArray();
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
        $beneficiariasLinkadas = [];

        foreach ($lista->beneficiarias as $value) {
            $beneficiariasLinkadas = $value->pivot;
        }

        Log::create([
            "user_id" => Auth::user()->id,
            "target_id" => $lista->id,
            "targeted_table" => "listas_beneficiarias",
            "action" => "create",
            "comment" => "Aprovação de lista de beneficiárias",
            "new_data" => "{lista:" . json_encode($lista->only("mes_referencia", "municipio", "created_by", "updated_at", "created_at")) . ", beneficiarias: " . json_encode($beneficiariasLinkadas) . "}",
            "old_data" => null
        ]);
        return true;
    }
}
