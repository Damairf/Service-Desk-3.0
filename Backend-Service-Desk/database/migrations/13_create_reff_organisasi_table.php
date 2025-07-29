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
        Schema::create('reff_organisasi', function (Blueprint $table) {
            $table->id('ID_Organisasi');
            $table->string('Nama_OPD')->nullable(false);
            $table->unsignedBigInteger('ID_Induk_Organisasi')->nullable();
            $table->string('Nama_Pengelola')->nullable(false);
            $table->string('No_HP_Pengelola')->nullable(false);
            $table->string('Email')->nullable(false);
            $table->enum('Status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();

            $table->foreign('ID_Induk_Organisasi')->references('ID_Organisasi')->on('reff_organisasi')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reff_organisasi');
    }
};
