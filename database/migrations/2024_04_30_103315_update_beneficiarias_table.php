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
        Schema::table('beneficiarias', function (Blueprint $table) {
            $table->integer("qtd_filhos_ate_7_anos")->default(0)->after("particip_programas_transferencia_renda");
            $table->integer("qtd_filhos_ate_12_anos")->default(0)->after("qtd_filhos_ate_7_anos");
            $table->integer("qtd_filhos_ate_18_anos")->default(0)->after("qtd_filhos_ate_12_anos");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiarias', function (Blueprint $table) {
            $table->dropColumn("qtd_filhos_ate_7_anos");
            $table->dropColumn("qtd_filhos_ate_12_anos");
            $table->dropColumn("qtd_filhos_ate_18_anos");
        });
    }
};
