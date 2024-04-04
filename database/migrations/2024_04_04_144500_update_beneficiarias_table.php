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
            $table->string("municipio_cod_ibge", 20)->nullable()->after("nome");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiarias', function (Blueprint $table) {
            $table->dropColumn("municipio_cod_ibge");
        });
    }
};
