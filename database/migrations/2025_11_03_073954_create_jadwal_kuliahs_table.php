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
        Schema::create('jadwal_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->foreignId("id_mata_kuliah")->constrained("mata_kuliahs")->onDelete("cascade");
            $table->foreignId("id_kelas")->constrained("kelas")->onDelete("cascade");
            $table->foreign('nip')
                ->references('nip') // Menunjuk ke kolom 'nip' di tabel dosens
                ->on('dosens')      // Di tabel dosens
                ->onDelete('cascade')->onUpdate("cascade");
            $table->date("tanggal");
            $table->time("waktu_mulai");
            $table->time("waktu_selesai");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kuliahs');
    }
};
