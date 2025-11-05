<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $fillable = ["nama_jurusan", "fakultas", "kode_jurusan"];

    public function mahasiswa() {
        return $this->hasMany(Mahasiswa::class);
    }
}
