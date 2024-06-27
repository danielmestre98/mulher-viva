<?php

namespace App\Models;

use App\Utils\ArrayOperations;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Beneficiarias extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected static $salarioMinimo =  1412;
    protected $fillable = [
        'nome',
        'municipio',
        'cpf',
        'nis',
        'nascimento',
        'rg',
        'orgao_emissor_rg',
        'data_emissao_rg',
        'uf_emissao_rg',
        'nome_mae',
        'cep',
        'tipo_logradouro',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'uf',
        'agencia',
        'conta',
        'pix',
        'tipo_conta',
        'banco',
        'sexo',
        'raca',
        'tipo_deficiencia',
        'email',
        'tipo_telefone',
        'telefone',
        'escolaridade',
        'terminou_ensino_medio',
        'terminou_ensino_fundamental',
        'municipio_naturalidade_ibge',
        'renda_media_familia',
        'quantidade_pessoas_familia',
        'situacao_rua',
        'inic_serv_acolh_institucional',
        'mulher_nao_branca',
        'presenca_pessoa_idosa',
        'presenca_pessoa_deficiente',
        'presenca_adolec_medida_socio_educativa',
        'presenca_jovem_sit_abrigamento',
        'particip_programas_transferencia_renda',
        'pontuacao',
        'status',
        'created_by',
        'qtd_filhos_ate_7_anos',
        'qtd_filhos_ate_12_anos',
        'qtd_filhos_ate_18_anos',
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
        if ($dados->solicitante->NUM_IDENTIDADE_PESSOA != -1 && $dados->solicitante->NUM_IDENTIDADE_PESSOA != "Não Informado" && $dados->solicitante->NUM_IDENTIDADE_PESSOA != "") {
            $dadosFormatados["rg"] = $dados->solicitante->NUM_IDENTIDADE_PESSOA;
            $dadosFormatados["orgao_emissor_rg"] = $dados->solicitante->SIG_ORGAO_EMISSOR_PESSOA;
            $dadosFormatados["uf_emissao_rg"] = $dados->solicitante->SIG_UF_IDENT_PESSOA;
            $dadosFormatados["data_emissao_rg"] = date('Y-m-d', strtotime($dados->solicitante->DTA_EMISSAO_IDENT_PESSOA));
        } else {
            $dadosFormatados["rg"] = null;
        }
        $dadosFormatados["nome_mae"] = $dados->solicitante->NOM_COMPLETO_MAE_PESSOA;
        $dadosFormatados["cep"] = $dados->solicitante->NUM_CEP_LOGRADOURO_FAM;
        $dadosFormatados["tipo_logradouro"] = $dados->solicitante->NOM_TIP_LOGRADOURO_FAM;
        $dadosFormatados["logradouro"] = $dados->solicitante->NOM_LOGRADOURO_FAM;
        $dadosFormatados["numero"] = $dados->solicitante->NUM_LOGRADOURO_FAM;
        $dadosFormatados["complemento"] = $dados->solicitante->DES_COMPLEMENTO_FAM;
        $dadosFormatados["bairro"] = $dados->solicitante->NOM_LOCALIDADE_FAM;
        $dadosFormatados["uf"] = "SP";
        $dadosFormatados["sexo"] = "F";
        switch ($dados->solicitante->COD_RACA_COR_PESSOA) {
            case "Branca":
                $dadosFormatados["raca"] = 1;
                break;

            case "Preta":
                $dadosFormatados["raca"] = 2;
                break;

            case "Amarela":
                $dadosFormatados["raca"] = 3;
                break;

            case "Parda":
                $dadosFormatados["raca"] = 4;
                break;

            case "Indígena":
                $dadosFormatados["raca"] = 5;
                break;

            case "Sem informação":
                $dadosFormatados["raca"] = 0;
                break;
        }

        $deficienciaVisual = [
            $dados->solicitante->IND_DEF_CEGUEIRA_MEMB,
            $dados->solicitante->IND_DEF_BAIXA_VISAO_MEMB,
        ];
        $deficienciaAuditiva = [
            $dados->solicitante->IND_DEF_SURDEZ_PROFUNDA_MEMB,
            $dados->solicitante->IND_DEF_SURDEZ_LEVE_MEMB,
        ];
        $deficienciaMental = [
            $dados->solicitante->IND_DEF_SINDROME_DOWN_MEMB,
            $dados->solicitante->IND_DEF_MENTAL_MEMB,
            $dados->solicitante->IND_DEF_TRANSTORNO_MENTAL_MEMB
        ];
        $deficienciaMotora = [
            $dados->solicitante->IND_DEF_FISICA_MEMB
        ];

        if ($dados->solicitante->COD_DEFICIENCIA_MEMB == 2) {
            $deficiencia = 0;
        } else {
            if (in_array(1, $deficienciaVisual)) {
                $deficiencia = 4;
            }
            if (in_array(1, $deficienciaAuditiva)) {
                $deficiencia = 1;
            }
            if (in_array(1, $deficienciaMental)) {
                $deficiencia = 3;
            }
            if (in_array(1, $deficienciaMotora)) {
                $deficiencia = 2;
            }
        }

        $dadosFormatados["tipo_deficiencia"] = $deficiencia;
        $dadosFormatados["email"] = $dados->solicitante->EMAIL_FAM;
        if ($dados->solicitante->IC_TIPO_CONTATO_1_FAM == "L  ") {
            $dadosFormatados["tipo_telefone"] = "CEL";
        } else if ($dados->solicitante->IC_TIPO_CONTATO_1_FAM == "R  ") {
            $dadosFormatados["tipo_telefone"] = "RES";
        }
        $dadosFormatados["telefone"] = $dados->solicitante->NUM_TEL_CONTATO_1_FAM;

        $escolaridade = "";

        $ensinoFundamental = [
            "Ensino Fundamental regular (duração 8 anos)",
            "Ensino Fundamental regular (duração 9 anos)",
            "Ensino Fundamental especial",
            "Ensino Fundamental EJA,séries finais (Supletivo,5ª a 8ª)",
            "Ensino Fundamental 5ª a 8ª séries, Médio 1º ciclo (Ginasial), Segunda fase do 1º grau",
            "Ensino Fundamental (duração 9 anos)"
        ];

        $ensinoMedio = [
            "Ensino Médio regular",
            "Ensino Médio especial",
            "Ensino Médio EJA (Supletivo)",
            "Ensino Médio, 2º grau, Médio 2º ciclo (Científico, Clássico, Técnico, Normal)",
            "Pré-vestibular"
        ];

        $superior = [
            "Superior, Aperfeiçoamento, Especialização, Mestrado, Doutorado"
        ];

        $nenhum = [
            "Nenhum"
        ];

        $nao_informado = [
            "Não Informado"
        ];

        $terminouCurso = $dados->solicitante->COD_CONCLUIU_FREQUENTOU_MEMB == 1 ? true : false;

        $sabeLerEscrever = $dados->solicitante->COD_SABE_LER_ESCREVER_MEMB == 1 ? true : false;
        $dadosFormatados["terminou_ensino_medio"] = false;
        $dadosFormatados["terminou_ensino_fundamental"] = false;

        if (ArrayOperations::findOnArray($dados->solicitante->COD_CURSO_FREQUENTOU_PESSOA_MEMB, $superior)) {
            if ($terminouCurso) {
                $escolaridade = 0;
            } else {
                $escolaridade = 14;
            }
        } else if (ArrayOperations::findOnArray($dados->solicitante->COD_CURSO_FREQUENTOU_PESSOA_MEMB, $ensinoMedio)) {
            if ($terminouCurso) {
                $dadosFormatados["terminou_ensino_medio"] = true;
                $dadosFormatados["terminou_ensino_fundamental"] = true;
                $escolaridade = 12;
            } else {
                $escolaridade = 9;
            }
        } else if (ArrayOperations::findOnArray($dados->solicitante->COD_CURSO_FREQUENTOU_PESSOA_MEMB, $ensinoFundamental)) {
            if ($terminouCurso) {
                $dadosFormatados["terminou_ensino_fundamental"] = true;
                $escolaridade = 9;
            } else if ($sabeLerEscrever) {
                $escolaridade = 16;
            } else {
                $escolaridade = 17;
            }
        } else if (ArrayOperations::findOnArray($dados->solicitante->COD_CURSO_FREQUENTOU_PESSOA_MEMB, $nenhum)) {
            if ($sabeLerEscrever) {
                $escolaridade = 16;
            } else {
                $escolaridade = 17;
            }
        } else {
            $escolaridade = 18;
        }

        $dadosFormatados["escolaridade"] = $escolaridade;
        $dadosFormatados["municipio_naturalidade_ibge"] = $dados->solicitante->COD_IBGE_MUNIC_NASC_PESSOA;






        $dadosFormatados["renda_media_familia"] = $dados->solicitante->VLR_RENDA_MEDIA_FAM;
        $dadosFormatados["quantidade_pessoas_familia"] = $dados->solicitante->QTD_PESSOAS_DOMIC_FAM;
        if ($dados->solicitante->COD_VIVE_FAM_RUA_MEMB == "2" ||  $dados->solicitante->COD_VIVE_FAM_RUA_MEMB == "-1") {
            $dadosFormatados["situacao_rua"] = false;
        } else {
            $dadosFormatados["situacao_rua"] = true;
        }
        $dadosFormatados["mulher_nao_branca"] = ($dados->solicitante->COD_RACA_COR_PESSOA != "Branca") ? true : false;
        $dadosFormatados["presenca_pessoa_idosa"] = ($dados->solicitante->DTA_NASC_PESSOA >= 65) ? true : false;
        $dadosFormatados["presenca_pessoa_deficiente"] = ($dados->solicitante->COD_DEFICIENCIA_MEMB == 1) ? true : false;
        $dadosFormatados["qtd_filhos_ate_7_anos"] = 0;
        $dadosFormatados["qtd_filhos_ate_12_anos"] = 0;
        $dadosFormatados["qtd_filhos_ate_18_anos"] = 0;
        $dadosFormatados["created_by"] = Auth::user()->id;

        foreach ($dados->familia as $value) {
            $idade = self::calcularIdade($value->DTA_NASC_PESSOA);
            if ($idade) {
                $dadosFormatados["presenca_pessoa_idosa"] = true;
            }
            if ($value->COD_DEFICIENCIA_MEMB == 1) {
                $dadosFormatados["presenca_pessoa_deficiente"] = true;
            }
            if ($idade < 7) {
                $dadosFormatados["qtd_filhos_ate_7_anos"]++;
            }
            if ($idade >= 7 && $idade < 12) {
                $dadosFormatados["qtd_filhos_ate_12_anos"]++;
            }
            if ($idade >= 12 && $idade < 18) {
                $dadosFormatados["qtd_filhos_ate_18_anos"]++;
            }
        }
        return $dadosFormatados;
    }

    static function calcularPontuacao($dados)
    {
        $pontuacao = 0;
        if ($dados->renda_media_familia <= 218) {
            $pontuacao += 5;
        } else if ($dados->renda_media_familia >= 218.01 && $dados->renda_media_familia <= self::$salarioMinimo * 1 / 4) {
            $pontuacao += 3;
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
            $pontuacao += 3;
        }
        if ($dados->presenca_pessoa_deficiente) {
            $pontuacao += 3;
        }
        if ($dados->presenca_jovem_sit_abrigamento) {
            $pontuacao += 1;
        }
        if ($dados->presenca_adolec_medida_socio_educativa) {
            $pontuacao += 1;
        }
        if ($dados->particip_programas_transferencia_renda) {
            $pontuacao += 1;
        } else {
            $pontuacao += 3;
        }

        if ($dados->escolaridade == 16 || $dados->escolaridade == 17) {
            $pontuacao += 5;
        } else {
            if ($dados->terminou_ensino_fundamental == true && $dados->terminou_ensino_medio == false) {
                $pontuacao += 1;
            }

            if ($dados->terminou_ensino_fundamental == false) {
                $pontuacao += 3;
            }
        }

        if ($dados->inic_serv_acolh_institucional) {
            $pontuacao += 5;
        }
        if ($dados->qtd_filhos_ate_7_anos) {
            $pontuacao += 5 * $dados->qtd_filhos_ate_7_anos;
        }
        if ($dados->qtd_filhos_ate_12_anos) {
            $pontuacao += 3 * $dados->qtd_filhos_ate_12_anos;
        }
        if ($dados->qtd_filhos_ate_18_anos) {
            $pontuacao += 1 * $dados->qtd_filhos_ate_18_anos;
        }

        return $pontuacao;
    }

    static function verificarPosicoes($municipioId)
    {
        $status = [5, 6];
        $beneficiariasAprovadas = Beneficiarias::where('municipio', $municipioId)->orderBy("pontuacao", "DESC")->whereIn("status", [1, 8])->get();
        $beneficiarias = Beneficiarias::where('municipio', $municipioId)->orderBy("pontuacao", "DESC")->whereIn("status", $status)->get();
        $lista = new Collection();
        $posicao = 1;
        for ($i = 0; $i < count($beneficiariasAprovadas); $i++) {
            $beneficiariasAprovadas[$i]->posicao = $posicao;
            $beneficiariasAprovadas[$i]->save();
            $lista->add($beneficiariasAprovadas[$i]);
            $posicao++;
        }

        for ($i = 0; $i < count($beneficiarias); $i++) {
            if ($beneficiarias[$i]->posicao != $posicao) {
                Log::create([
                    "user_id" => Auth::user()->id,
                    "target_id" => $beneficiarias[$i]->id,
                    "targeted_table" => "beneficiarias",
                    "action" => "update",
                    "comment" => "Ajuste de posição na lista",
                    "new_data" => "{posicao:" . $posicao . "}",
                    "old_data" => "{posicao:" . $beneficiarias[$i]->posicao . "}"
                ]);
            }
            $beneficiarias[$i]->posicao = $posicao;
            $beneficiarias[$i]->save();
            $lista->add($beneficiarias[$i]);
            $posicao++;
        }

        ListasBeneficiarias::checkList(Auth::user()->municipio, $lista);
    }

    function statusCodes()
    {
        return $this->belongsTo(StatusCodes::class, "status", "id");
    }

    function municipios()
    {
        return $this->belongsTo(Municipio::class, "municipio", "id");
    }

    public function listas()
    {
        return $this->belongsToMany(ListasBeneficiarias::class, 'lista_beneficiaria_relation', "beneficiara", "lista");
    }
}
