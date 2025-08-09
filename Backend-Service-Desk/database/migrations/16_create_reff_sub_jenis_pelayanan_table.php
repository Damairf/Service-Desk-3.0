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
        Schema::create('reff_sub_jenis_pelayanan', function (Blueprint $table) {
            $table->id('ID_Sub_Jenis_Pelayanan');
            $table->text('Nama_Sub_Jenis_Pelayanan')->nullable(false);
            $table->unsignedBigInteger('ID_Jenis_Pelayanan')->nullable(true);
            $table->string('Persyaratan')->nullable(false);
            $table->timestamps();
            
            $table->foreign('ID_Jenis_Pelayanan')->references('ID_Jenis_Pelayanan')->on('reff_jenis_pelayanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reff_sub_jenis_pelayanan');
    }
};
