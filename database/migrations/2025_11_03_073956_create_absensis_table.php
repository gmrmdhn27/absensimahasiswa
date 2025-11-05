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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_jadwal")->constrained("jadwal_kuliahs")->onDelete("cascade");
            $table->foreignId("nim")->constrained("mahasiswas")->onDelete("cascade");
            $table->date("tanggal_absen");
            $table->enum("status_kehadiran", ["hadir", "alfa", "izin", "sakit"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
