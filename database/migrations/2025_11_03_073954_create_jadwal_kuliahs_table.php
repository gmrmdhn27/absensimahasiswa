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
            $table->string('id_mata_kuliah'); // Ubah tipe data menjadi string
            $table->string('nip');
            $table->foreignId("id_kelas")->constrained("kelas")->onDelete("cascade");

            // Definisikan foreign key secara manual
            $table->foreign('id_mata_kuliah')->references('kode_mk')->on('mata_kuliahs')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('nip')
                ->references('nip')
                ->on('dosens')
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
