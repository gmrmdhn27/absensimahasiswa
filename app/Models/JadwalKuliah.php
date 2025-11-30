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
     * Mendefinisikan relasi "belongsTo" ke model Dosen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        // Relasi ke tabel 'dosens' menggunakan 'nip' sebagai foreign key dan 'nip' sebagai owner key.
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'id_mata_kuliah', 'kode_mk'); // Relasi ke tabel mata_kuliahs
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
