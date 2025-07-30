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
        Schema::create('chat', function (Blueprint $table) {
            $table->id('ID_Chat');
            $table->unsignedBigInteger('ID_User')->nullable(false);
            $table->string('ID_Pelayanan', 10)->nullable(false);
            $table->string('Chat')->nullable(true);
            $table->timestamps();

            $table->foreign('ID_User')->references('ID_User')->on('user');
            $table->foreign('ID_Pelayanan')->references('ID_Pelayanan')->on('pelayanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
