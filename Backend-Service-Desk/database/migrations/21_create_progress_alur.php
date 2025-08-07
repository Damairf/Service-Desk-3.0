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
        Schema::create('progress_alur', function (Blueprint $table) {
            $table->id("ID_Progress_Alur");
            $table->string("ID_Pelayanan", 10)->nullable(false);
            $table->unsignedBigInteger("ID_Alur")->nullable(false);
            $table->boolean("Is_Done")->default(false)->nullable(false);
            $table->timestamps();

            $table->foreign('ID_Pelayanan')->references('ID_Pelayanan')->on('pelayanan');
            $table->foreign('ID_Alur')->references('ID_Alur')->on('alur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_alur');
    }
};
