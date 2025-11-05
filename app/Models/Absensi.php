<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = ["id_jadwal", "nim", "tanggal_absen", "status_kehadiran"];

    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function jadwal() {
        return $this->belongsTo(JadwalKuliah::class, "id_jadwal");
    }
}
