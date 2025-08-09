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
        Schema::create('alur', function (Blueprint $table) {
            $table->id('ID_Alur');
            $table->unsignedBigInteger('ID_Sub_Jenis_Pelayanan')->nullable(false);
            $table->unsignedBigInteger('ID_Isi_Alur')->nullable(false);
            $table->timestamps();
            
            $table->foreign('ID_Sub_Jenis_Pelayanan')->references('ID_Sub_Jenis_Pelayanan')->on('reff_sub_jenis_pelayanan')->onDelete('cascade');
            $table->foreign('ID_Isi_Alur')->references('ID_Isi_Alur')->on('reff_isi_alur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alur');
    }
};
