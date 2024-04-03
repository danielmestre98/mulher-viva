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
        Schema::create('drads', function (Blueprint $table) {
            $table->id();
            $table->string("nome")->nullable();
            $table->string("bairro")->nullable();
            $table->string("endereco")->nullable();
            $table->string("telefone")->nullable();
            $table->string("cep")->nullable();
            $table->string("diretor")->nullable();
            $table->foreignId("id_municipio")->references("id")->on("municipios");
            $table->integer("cod_uge")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drads');
    }
};
