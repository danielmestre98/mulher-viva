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
            $table->string("renda_media_familia");
            $table->string("quantidade_pessoas_familia");
            $table->boolean("situacao_rua");
            $table->boolean("terminou_ensino_medio");
            $table->boolean("inic_serv_acolh_institucional");
            $table->boolean("mulher_nao_branca");
            $table->boolean("presenca_pessoa_idosa");
            $table->boolean("presenca_pessoa_deficiente");
            $table->boolean("presenca_adolec_medida_socio_educativa");
            $table->boolean("presenca_jovem_sit_abrigamento");
            $table->boolean("particip_programas_transferencia_renda");
            $table->string('pontuacao');
            $table->integer("status");
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
