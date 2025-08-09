<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function GuzzleHttp\default_ca_bundle;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelayanan', function (Blueprint $table) {
            $table->string('ID_Pelayanan', 10)->primary();
            $table->unsignedBigInteger('ID_User')->nullable(false);
            $table->string('Nama_Pelapor')->nullable(false);
            $table->unsignedBigInteger('ID_Urgensi')->nullable(true);
            $table->unsignedBigInteger('ID_Jenis_Pelayanan')->nullable(false);
            $table->unsignedBigInteger('ID_Sub_Jenis_Pelayanan')->nullable(false);
            $table->string('Perihal')->nullable(false);
            $table->text('Deskripsi')->nullable(false);
            $table->string('Surat_Dinas_Path')->nullable(false);
            $table->unsignedBigInteger('ID_Status')->nullable(false)->default(1);
            $table->string('Lampiran_Path')->nullable(false);
            $table->unsignedBigInteger('ID_Unit')->nullable(true);
            $table->string('Pesan_Pengelola')->nullable(true);
            $table->unsignedBigInteger('ID_Teknis')->nullable(true);
            $table->string('Pesan_Unit')->nullable(true);
            $table->boolean('Is_Done')->default(false);
            $table->string('Pesan_Revisi')->nullable(true);
            $table->string('Hasil_Pemenuhan_Path')->nullable(true);
            $table->string('BA_Path')->nullable(true);
            $table->string('SLA_Path')->nullable(true);
            $table->enum('Rating', ['1', '2','3', '4', '5'])->nullable(true);
            $table->string('Isi_Survey')->nullable(true);
            $table->timestamps();

            $table->foreign('ID_User')->references('ID_User')->on('user');
            $table->foreign('ID_Status')->references('ID_Status')->on('reff_status');
            $table->foreign('ID_Unit')->references('ID_User')->on('user');
            $table->foreign('ID_Teknis')->references('ID_User')->on('user');
            $table->foreign('ID_Jenis_Pelayanan')->references('ID_Jenis_Pelayanan')->on('reff_jenis_pelayanan');
            $table->foreign('ID_Sub_Jenis_Pelayanan')->references('ID_Sub_Jenis_Pelayanan')->on('reff_sub_jenis_pelayanan');
            $table->foreign('ID_Urgensi')->references('ID_Urgensi')->on('reff_urgensi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan');
    }
};
