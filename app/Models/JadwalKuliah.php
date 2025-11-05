<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;
    protected $fillable = ["id_mata_kuliah", "id_kelas", "tanggal", "waktu_mulai", "nip"];
    public function absensi() {
        return $this->hasMany(Absensi::class, "id_jadwal");
    }

    public function mataKuliah() {
        return $this->belongsTo(MataKuliah::class, "id_mata_kuliah", "id");
    }

    public function dosen() {
        return $this->belongsTo(Dosen::class, "nip", "nip");
    }

    public function kelas() {
        return $this->belongsTo(Kelas::class, "id_kelas");
    }
}
