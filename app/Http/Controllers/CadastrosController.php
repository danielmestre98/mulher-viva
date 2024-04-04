<?php

namespace App\Http\Controllers;

use App\Models\Beneficiarias;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CadastrosController extends Controller
{
    function index($filtro = "")
    {
        $dados = [];
        if ($filtro != "") {
            $dados = Beneficiarias::where('status', $filtro)->get();
        } else {
            $dados = Beneficiarias::all();
        }
        return view("cadastros.index", ["beneficiarias" => $dados]);
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

    function approve($option)
    {
    }
}
