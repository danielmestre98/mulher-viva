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
            $table->string("municipio", 20)->nullable()->after("nome");
            $table->text("motivo_recusa")->nullable()->after("status");
            $table->foreignId("created_by")->references("id")->on("users")->after("motivo_recusa");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiarias', function (Blueprint $table) {
            $table->dropColumn("municipio");
            $table->dropColumn("motivo_recusa");
            $table->dropColumn("created_by");
        });
    }
};
