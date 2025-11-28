<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $fillable = ["nama_mk", "sks", "kode_mk"];

    protected $primaryKey = 'kode_mk';

    public $incrementing = false;

    protected $keyType = 'string';

    public function jadwalKuliahs() {
        return $this->hasMany(JadwalKuliah::class, 'id_mata_kuliah', 'kode_mk');
    }
}
