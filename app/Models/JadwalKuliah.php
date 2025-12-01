<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kuliahs';

    protected $fillable = [
        'id_mata_kuliah',
        'id_kelas',
        'nip',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
    ];

    /**
     * Relasi ke model MataKuliah.
     *
     * Foreign Key: 'id_mata_kuliah' di tabel ini.
     * Owner Key: 'id' di tabel mata_kuliahs.
     */
     public function mataKuliah()
     {
         return $this->belongsTo(MataKuliah::class, 'id_mata_kuliah', 'kode_mk');
     }

    /**
     * Relasi ke model Kelas.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    /**
     * Relasi ke model Dosen.
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }

    /**
     * Relasi ke model Absensi.
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_jadwal');
    }
}
