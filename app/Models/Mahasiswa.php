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

    /**
     * Relasi one-to-many dengan model Absensi.
     * Mahasiswa dapat memiliki banyak catatan absensi.
     */
    public function absensi() {
        return $this->hasMany(Absensi::class, "nim", "nim");
    }

    /**
     * Relasi belongs-to dengan model Jurusan.
     * Mahasiswa hanya memiliki satu jurusan.
     */
    public function jurusan() {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Relasi many-to-many dengan model Kelas melalui tabel pivot kelas_mahasiswas.
     * Seorang mahasiswa dapat terdaftar di banyak kelas (walaupun mungkin hanya satu yang aktif).
     */
    public function kelas() {
        // Argumen:
        // 1. Model tujuan: Kelas::class
        // 2. Nama tabel pivot: 'kelas_mahasiswas'
        // 3. Foreign key di pivot untuk model INI (Mahasiswa): 'nim'
        // 4. Foreign key di pivot untuk model TUJUAN (Kelas): 'id_kelas'
        // 5. Local key (primary key) di model INI (Mahasiswa): 'nim'
        // 6. Local key (primary key) di model TUJUAN (Kelas): 'id'
        return $this->belongsToMany(Kelas::class, 'kelas_mahasiswas', 'nim', 'id_kelas', 'nim', 'id')
                    ->using(KelasMahasiswa::class);
    }

    /**
     * Relasi one-to-many dengan model KelasMahasiswa.
     * Seorang mahasiswa dapat memiliki banyak catatan di tabel kelas_mahasiswas (riwayat kelas).
     */
    public function kelasMahasiswa()
    {
        return $this->hasMany(KelasMahasiswa::class, 'nim', 'nim');
    }
}
