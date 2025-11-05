<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasMahasiswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'nim';

    protected $fillable = ["nim", "id_kelas"];

    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class, "nim", "nim");
    }

    public function kelas()
    {
        // Sintaks: belongsTo(Model Tujuan, Foreign Key di tabel KelasMahasiswa, Local Key di tabel Kelas)
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }
}
