<?php

namespace App\Http\Controllers;

use App\Models\Judicializacao;
use App\Models\Log;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Utils\StringOperations;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class JudicializacaoController extends Controller
{
    function index()
    {
        $judicializacoes = Judicializacao::all();
        return view("judicializacao.index", ["judicializacoes" => $judicializacoes]);
    }

    function create()
    {
        $municipios = Municipio::all();
        return view("judicializacao.create", ["municipios" => $municipios]);
    }

    function store(Request $request)
    {
        $beneficiaria = $request->only("nome", "cpf", "rg", "municipio", "numero_processo", "data_processo");
        $beneficiaria["cpf"] = StringOperations::removeSpecialCharacters($beneficiaria["cpf"]);
        $beneficiaria["rg"] = StringOperations::removeSpecialCharacters($beneficiaria["rg"]);
        $beneficiaria = Judicializacao::create($beneficiaria);
        $request->file("anexoDespacho")->storeAs("judicializacoes/" . $beneficiaria->id . "/judicializacao.pdf");
        $pdfFile = Storage::get("judicializacoes/" . $beneficiaria->id . "/judicializacao.pdf");
        $encryptedFile = Judicializacao::encryptPdf($pdfFile);
        Storage::put("judicializacoes/" . $beneficiaria->id . "/judicializacao.pdf", $encryptedFile);
        Log::create([
            "user_id" => Auth::user()->id,
            "target_id" => $beneficiaria->id,
            "targeted_table" => "judicializacao",
            "beneficiaria" => $beneficiaria->id,
            "action" => "create",
            "comment" => "Cadastro de beneficiária com judicialização",
            "new_data" => $beneficiaria->toJson(),
            "old_data" => null
        ]);
        return redirect()->route("restrito.judicializacoes");
    }

    function view($id)
    {
        $judicializacao = Judicializacao::find($id);
        return view("judicializacao.view", ["beneficiaria" => $judicializacao]);
    }

    function viewPdf($id)
    {
        $pdfFile = Storage::get("judicializacoes/" . $id . "/judicializacao.pdf");
        $decryptedPdf = Judicializacao::decryptPdf($pdfFile);
        // $pdf = PDF::loadView('assets.pdf', ["data" => $decryptedPdf]);
        return response()->make($decryptedPdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="judicializacao.pdf"'
        ]);
    }
}
