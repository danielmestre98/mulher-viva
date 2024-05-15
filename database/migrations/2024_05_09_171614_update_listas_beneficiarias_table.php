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
        Schema::table('listas_beneficiarias', function (Blueprint $table) {
            $table->bigInteger("municipio")->after("mes_referencia");
            $table->foreign("municipio")->after("mes_referencia")->references("id")->on("municipios");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listas_beneficiarias', function (Blueprint $table) {
            $table->dropColumn("municipio");
        });
    }
};
