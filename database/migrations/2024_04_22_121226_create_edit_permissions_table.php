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
        Schema::create('edit_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("beneficiaria")->references("id")->on("beneficiarias");
            $table->integer("field");
            $table->boolean("used")->default(false);
            $table->foreignId("created_by")->references("id")->on("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edit_permissions');
    }
};
