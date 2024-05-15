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
        Schema::create('lista_beneficiaria_relation', function (Blueprint $table) {

            $table->foreignId("listas")->references("id")->on("listas_beneficiarias")->onDelete("cascade");
            $table->foreignId("beneficiarias")->references("id")->on("beneficiarias")->onDelete("cascade");

            $table->primary(['listas', 'beneficiarias']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_beneficiaria_relation');
    }
};
