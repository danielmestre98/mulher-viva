<?php

namespace App\Http\Controllers;

use App\Models\Beneficiarias;
use App\Models\Drads;
use App\Models\Municipio;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use stdClass;

class CadastrosController extends Controller
{
    function index($filtro = "")
    {
        $dados = [];
        if ($filtro != "") {
            if (Auth::user()->can("view beneficiarias")) {
                $drads = Drads::orderBy("nome", "ASC")->get();
                $municipios = Municipio::orderBy("nome", "ASC")->get();
                $dados = Beneficiarias::where('status', $filtro)->get();
                return view("cadastros.index", ["beneficiarias" => $dados, "drads" => $drads, "municipios" => $municipios, "filtro" => $filtro]);
            } else {
                $dados = Beneficiarias::where('status', $filtro)->where('municipio', Auth::user()->municipio)->get();
            }
        } else {
            if (Auth::user()->can("view beneficiarias")) {
                $dados = Beneficiarias::all();
                $drads = Drads::orderBy("nome", "ASC")->get();
                $municipios = Municipio::orderBy("nome", "ASC")->get();
                return view("cadastros.index", ["beneficiarias" => $dados, "drads" => $drads, "municipios" => $municipios, "filtro" => $filtro]);
            } else {
                $dados = Beneficiarias::where('municipio', Auth::user()->municipio)->get();
            }
        }
        return view("cadastros.index", ["beneficiarias" => $dados, "filtro" => $filtro]);
    }

    function filter(Request $request)
    {
        $drads = Drads::orderBy("nome", "ASC")->get();
        $municipios = Municipio::orderBy("nome", "ASC")->get();
        if ($request->drads_filtro) {
            $municipio = Municipio::where("drads_id", $request->drads_filtro)->pluck("id");
            $beneficiarias = isset($request->filtro) ? Beneficiarias::where("status", $request->filtro)->whereIn("municipio", $municipio)->get() :
                Beneficiarias::whereIn("municipio", $municipio)->get();
        } else {
            $municipio = Municipio::where("id", $request->municipio_filtro)->pluck("id");
            $beneficiarias = isset($request->filtro) ? Beneficiarias::where("status", $request->filtro)->whereIn("municipio", $municipio)->get() :
                Beneficiarias::whereIn("municipio", $municipio)->get();
        }
        return view("cadastros.index", ["beneficiarias" => $beneficiarias, "filtro" => $request->filtro, "drads" => $drads, "municipios" => $municipios, "filtros_default" => ["drads" => $request->drads_filtro, "municipio" => $request->municipio_filtro]]);
    }

    function view($idBeneficiaria)
    {
        $beneficiaria = Beneficiarias::find($idBeneficiaria);
        return view("cadastros.view", ["beneficiaria" => $beneficiaria]);
    }


    function searchNewBeneficiaria(Request $request)
    {
        $jaExiste = Beneficiarias::where("cpf", "=", $request->valorPesquisa)->first();
        if (!empty($jaExiste)) {
            return response()->json([
                "error" => "não encontrado no cadunico",
            ], 403);
        }
        $headers = [
            'Token' => env("API_TOKEN"),
        ];

        $response = Http::withHeaders($headers)->post(env("API_URL"), [
            'sistema' => 'mulher-viva',
            'searchType' => $request->tipoPesquisa,
            'cpf' => [
                $request->valorPesquisa
            ],
            'nis' => [
                $request->valorPesquisa
            ]
        ]);

        // Verificar a resposta
        if ($response->successful()) {
            // A requisição foi bem-sucedida (status 2xx)
            $data = $response->json(); // Se a resposta for JSON
            if (!isset($data["erro"])) {
                $solicitante = $data[0]["solicitante"];
                $familia = $data[0]["familia"];
                if (floatval($solicitante["VLR_RENDA_MEDIA_FAM"]) <= 1412 && $solicitante["COD_MUNIC_IBGE_2_FAM"] == 35) {
                    return response()->json([
                        "aprovada" => true,
                        "solicitante" => $solicitante,
                        "familia" => $familia
                    ]);
                }
                //Mulher não elegível 
                $json = json_encode($solicitante);
                $json2 = json_encode($familia);
                // Transforma o JSON em um objeto stdClass
                $objeto = json_decode($json);
                $objeto2 = json_decode($json2);
                $class = new stdClass();

                $class->solicitante = $objeto;
                $class->familia = $objeto2;
                $dadosFormatados = Beneficiarias::formatarDados($class);
                $this->storeNaoElegivel($dadosFormatados);


                return response()->json([
                    "aprovada" => false,
                ]);
            }
            return response()->json([
                "error" => "não encontrado no cadunico",
            ], 401);

            // Faça algo com os dados...
        } else {
            // A requisição falhou (status diferente de 2xx)
            $statusCode = $response->status();
            // Lida com o erro...
        }
    }

    function create(Request $request)
    {
        $dados = json_decode($request->jsonMulher);
        $dadosFormtados = Beneficiarias::formatarDados($dados);

        return view("cadastros.create", ["dados" => $dadosFormtados]);
    }

    function storeNaoElegivel($dados)
    {
        $json = json_encode($dados);
        // Transforma o JSON em um objeto stdClass
        $objeto = json_decode($json);
        $objeto->presenca_jovem_sit_abrigamento = 0;
        $objeto->presenca_adolec_medida_socio_educativa = 0;
        $objeto->inic_serv_acolh_institucional = 0;
        $objeto->particip_programas_transferencia_renda = 0;
        $objeto->pontuacao = 0;
        $objeto->status = 4;
        $date = DateTime::createFromFormat('d/m/Y', $objeto->nascimento);
        $objeto->nascimento = $date->format('Y-m-d');
        Beneficiarias::create(json_decode(json_encode($objeto), true));
        return redirect()->route("restrito.cadastros");
    }

    function store(Request $request)
    {
        $dadosCadastroUnico = json_decode($request->jsonDados);
        $dadosCadastroUnico->presenca_jovem_sit_abrigamento = json_decode($request->criancaAbrig);
        $dadosCadastroUnico->presenca_adolec_medida_socio_educativa = json_decode($request->adolecMedidaSocio);
        $dadosCadastroUnico->inic_serv_acolh_institucional = json_decode($request->mulherCondDesacolh);
        $dadosCadastroUnico->particip_programas_transferencia_renda = json_decode($request->familiaTransfRenda);
        $dadosCadastroUnico->pontuacao = Beneficiarias::calcularPontuacao($dadosCadastroUnico);
        $dadosCadastroUnico->status = 2;
        $date = DateTime::createFromFormat('d/m/Y', $dadosCadastroUnico->nascimento);
        $dadosCadastroUnico->nascimento = $date->format('Y-m-d');
        $beneficiaria =  Beneficiarias::create(json_decode(json_encode($dadosCadastroUnico), true));
        // dd($request);
        $anexoMedidaProt = $request->file('anexoMedidaProt')->storeAs("uploads/" . $beneficiaria->id, "medidaProtetiva." . $request->file('anexoMedidaProt')->getClientOriginalExtension(), "public");
        $anexoExamePsico = $request->file('anexoExamePsico')->storeAs("uploads/" . $beneficiaria->id, "examePsicosocial." . $request->file('anexoExamePsico')->getClientOriginalExtension(), "public");

        // // Check if the file is valid
        // if ($anexoMedidaProt->isValid() && $anexoExamePsico->isValid()) {
        //     // Store the file in the public disk
        //     $path = Storage::disk('public')->put('uploads/' . $beneficiaria->id . "/medidaProtetiva." . $anexoMedidaProt->getClientOriginalExtension(), $anexoMedidaProt,);
        //     $path2 = Storage::disk('public')->put('uploads/' . $beneficiaria->id, $anexoExamePsico);

        //     dd($path);

        //     // $path contains the relative path of the stored file, e.g., 'uploads/example.jpg'
        //     // You can use this path to access the file in your application
        // } else {
        //     // Handle invalid file
        // }

        return redirect()->route("restrito.cadastros");
    }

    function approve(Request $request, $id, $option)
    {
        if ($option == 1) {
            $beneficiaria = Beneficiarias::find($id);
            $beneficiaria->status = 1;
            $beneficiaria->save();
        } else {
            $beneficiaria = Beneficiarias::find($id);
            $beneficiaria->status = 3;
            $beneficiaria->motivo_recusa = $request->motivo_recusa;
            $beneficiaria->save();
        }
        return redirect()->route("restrito.cadastros.filtro.aprovado");
    }
}
