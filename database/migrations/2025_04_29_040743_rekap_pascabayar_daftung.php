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
        Schema::create('rekap_pascabayar_daftung', function (Blueprint $table) {
            $table->id();
            $table->string('unit_ulp_pascabayar')->nullable();
            $table->string('target_bulanan')->nullable();
            $table->string('target_mingguan')->nullable();
            $table->string('target_harian')->nullable();
            $table->string('tanggal_realisasi')->nullable();
            $table->string('realisasi')->nullable();
            $table->string('persen_pencapaian')->nullable();
            $table->string('unit_ulp_daftung')->nullable();
            $table->string('daftung_pagi')->nullable();
            $table->string('cetak_pk_pagi')->nullable();
            $table->string('cetak_pk_siang')->nullable();
            $table->string('jumlah_peremajaan')->nullable();
            $table->timestamps();
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
