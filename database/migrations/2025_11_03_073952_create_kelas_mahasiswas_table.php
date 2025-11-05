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
        Schema::create('kelas_mahasiswas', function (Blueprint $table) {
            $table->string('nim');
            $table->foreign("nim")->references("nim")->on("mahasiswas")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("id_kelas")->constrained("kelas")->onDelete("cascade");
            $table->timestamps();
            $table->primary(['nim', 'id_kelas']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_mahasiswas');
    }
};
