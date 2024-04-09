<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Beneficiarias extends Model
{
    use HasFactory;
    protected static $salarioMinimo =  1412;
    protected $fillable = [
        'nome',
        'municipio',
        'cpf',
        'nis',
        'nascimento',
        'renda_media_familia',
        'quantidade_pessoas_familia',
        'situacao_rua',
        'terminou_ensino_medio',
        'inic_serv_acolh_institucional',
        'mulher_nao_branca',
        'presenca_pessoa_idosa',
        'presenca_pessoa_deficiente',
        'presenca_adolec_medida_socio_educativa',
        'presenca_jovem_sit_abrigamento',
        'particip_programas_transferencia_renda',
        'pontuacao',
        'status',
        'created_by'
    ];

    static private $ensinoMedio = [
        "Ensino Médio regular",
        "Ensino Médio especial",
        "Superior, Aperfeiçoamento, Especialização, Mestrado, Doutorado"
    ];

    static private function calcularIdade($dataNascimento)
    {
        // Converte a data de nascimento para um objeto DateTime
        $dataNascimento = new DateTime($dataNascimento);

        // Obtém a data atual
        $dataAtual = new DateTime();

        // Calcula a diferença entre as datas
        $diferenca = $dataNascimento->diff($dataAtual);

        // Retorna a idade
        return $diferenca->y;
    }


    static function formatarDados($dados)
    {
        $dadosFormatados = [];
        $dadosFormatados["nome"] =  $dados->solicitante->NOM_PESSOA;
        $dadosFormatados["municipio"] = Auth::user()->municipio;
        $dadosFormatados["cpf"] = $dados->solicitante->NUM_CPF_PESSOA;
        $dadosFormatados["nis"] = $dados->solicitante->NUM_NIS_PESSOA_ATUAL;
        $dadosFormatados["nascimento"] = date('d/m/Y', strtotime($dados->solicitante->DTA_NASC_PESSOA));
        $dadosFormatados["renda_media_familia"] = $dados->solicitante->VLR_RENDA_MEDIA_FAM;
        $dadosFormatados["quantidade_pessoas_familia"] = $dados->solicitante->QTD_PESSOAS_DOMIC_FAM;
        if ($dados->solicitante->COD_VIVE_FAM_RUA_MEMB == "2" ||  $dados->solicitante->COD_VIVE_FAM_RUA_MEMB == "-1") {
            $dadosFormatados["situacao_rua"] = false;
        } else {
            $dadosFormatados["situacao_rua"] = true;
        }
        $dadosFormatados["terminou_ensino_medio"] = in_array($dados->solicitante->COD_CURSO_FREQUENTOU_PESSOA_MEMB, self::$ensinoMedio);
        $dadosFormatados["mulher_nao_branca"] = ($dados->solicitante->COD_RACA_COR_PESSOA != "Branca") ? true : false;
        $dadosFormatados["presenca_pessoa_idosa"] = ($dados->solicitante->DTA_NASC_PESSOA >= 65) ? true : false;
        $dadosFormatados["presenca_pessoa_deficiente"] = ($dados->solicitante->COD_DEFICIENCIA_MEMB == 1) ? true : false;
        $dadosFormatados["created_by"] = Auth::user()->id;

        foreach ($dados->familia as $value) {
            if (self::calcularIdade($value->DTA_NASC_PESSOA) >= 65) {
                $dadosFormatados["presenca_pessoa_idosa"] = true;
            }
            if ($value->COD_DEFICIENCIA_MEMB == 1) {
                $dadosFormatados["presenca_pessoa_deficiente"] = true;
            }
        }
        return $dadosFormatados;
    }

    static function calcularPontuacao($dados)
    {
        $pontuacao = 0;
        if ($dados->renda_media_familia <= self::$salarioMinimo * 1 / 4) {
            $pontuacao += 3;
        } else if ($dados->renda_media_familia >= self::$salarioMinimo * 1 / 4 && $dados->renda_media_familia <= self::$salarioMinimo * 1 / 2) {
            $pontuacao += 2;
        } else {
            $pontuacao += 1;
        }
        if ($dados->quantidade_pessoas_familia <= 2) {
            $pontuacao += 1;
        } else if ($dados->quantidade_pessoas_familia <= 4) {
            $pontuacao += 2;
        } else {
            $pontuacao += 3;
        }
        if ($dados->presenca_pessoa_idosa) {
            $pontuacao += 1;
        }
        if ($dados->presenca_pessoa_deficiente) {
            $pontuacao += 1;
        }
        if ($dados->presenca_jovem_sit_abrigamento) {
            $pontuacao += 1;
        }
        if ($dados->presenca_adolec_medida_socio_educativa) {
            $pontuacao += 1;
        }
        if ($dados->particip_programas_transferencia_renda) {
            $pontuacao += 1;
        }
        if (!$dados->terminou_ensino_medio) {
            $pontuacao += 1;
        }
        if ($dados->inic_serv_acolh_institucional) {
            $pontuacao += 1;
        }
        if ($dados->mulher_nao_branca) {
            $pontuacao += 1;
        }
        if ($dados->situacao_rua) {
            $pontuacao += 1;
        }

        return $pontuacao;
    }

    static function verificarPosicoes($municipioId)
    {
        $beneficiarias = Beneficiarias::where('municipio', $municipioId)->orderBy("pontuacao", "DESC")->where("status", "!=", 4)->get();
        for ($i = 0; $i < count($beneficiarias); $i++) {
            $beneficiarias[$i]->posicao = $i + 1;
            $beneficiarias[$i]->save();
        }
    }

    function statusCodes()
    {
        return $this->belongsTo(StatusCodes::class, "status", "id");
    }

    function municipios()
    {
        return $this->belongsTo(Municipio::class, "municipio", "id");
    }
}
