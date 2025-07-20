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
        Schema::create('reff_jenis_pelayanan', function (Blueprint $table) {
            $table->id('ID_Jenis_Pelayanan');
            $table->text('Nama_Jenis_Pelayanan')->nullable(false);
            $table->string('Persyaratan')->nullable(false);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reff_jenis_pelayanan');
    }
};
