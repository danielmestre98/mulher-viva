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
            $table->bigInteger("id");
            $table->string("nome")->nullable();
            $table->string("bairro")->nullable();
            $table->string("endereco")->nullable();
            $table->string("telefone")->nullable();
            $table->string("cep")->nullable();
            $table->string("diretor")->nullable();
            $table->bigInteger('id_municipio');
            $table->integer("cod_uge")->nullable();

            $table->foreign("id_municipio")->references("id")->on("municipios");
            $table->primary('id', 'your_table_primary_id');
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
