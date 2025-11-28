<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ["nama_kelas", "tahun_ajaran", "semester"];

    public function mahasiswas() {
        return $this->belongsToMany(Mahasiswa::class, "kelas_mahasiswas", "nim", "id_kelas")->using(KelasMahasiswa::class);
    }

    public function jadwalKuliah() {
        return $this->hasMany(JadwalKuliah::class);
    }
}
