<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beneficiarias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf');
            $table->string('nis');

            $table->string('rg')->nullable();
            $table->string('orgao_emissor_rg')->nullable();
            $table->date('data_emissao_rg')->nullable();;
            $table->string("uf_emissao_rg")->nullable();;
            $table->string('nome_mae')->nullable();
            $table->string('cep', 30)->nullable();
            $table->string('tipo_logradouro', 50)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero', 30)->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('uf', 5)->nullable();
            $table->string('agencia', 20)->nullable();
            $table->string('conta', 20)->nullable();
            $table->boolean('pix')->nullable();
            $table->string('tipo_conta', 20)->nullable();
            $table->string('banco', 20)->nullable();
            $table->string('sexo', 1)->nullable();
            $table->integer('raca')->nullable();
            $table->integer('tipo_deficiencia')->nullable();
            $table->string('email')->nullable();
            $table->string('tipo_telefone')->nullable();
            $table->string('telefone')->nullable();
            $table->integer('escolaridade')->nullable();
            $table->boolean('terminou_ensino_medio')->default(0);
            $table->boolean('terminou_ensino_fundamental')->default(0);
            $table->integer('municipio_naturalidade_ibge')->nullable();

            $table->string("renda_media_familia");
            $table->string("quantidade_pessoas_familia");
            $table->boolean("situacao_rua");
            $table->boolean("inic_serv_acolh_institucional");
            $table->boolean("mulher_nao_branca");
            $table->boolean("presenca_pessoa_idosa");
            $table->boolean("presenca_pessoa_deficiente");
            $table->boolean("presenca_adolec_medida_socio_educativa");
            $table->boolean("presenca_jovem_sit_abrigamento");
            $table->boolean("particip_programas_transferencia_renda");
            $table->integer('pontuacao');
            $table->integer("status");
            $table->integer("posicao")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficirias');
    }
};
