<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $fillable = ["nim", "nama", "user_id", "jurusan_id", "angkatan"];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function absensi() {
        return $this->hasMany(Absensi::class, "nim", "nim");
    }

    public function jurusan() {
        return $this->belongsTo(Jurusan::class);
    }

    public function kelas() {
        return $this->belongsToMany(Kelas::class, "kelas_mahasiswas", "nim", "id_kelas")->using(KelasMahasiswa::class);
    }

    public function kelasMahasiswa()
    {
        return $this->hasOne(KelasMahasiswa::class, 'nim', 'nim');
    }
}
