<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = ["nip", "nama", "departemen", "user_id"];

    public function jadwalKuliahs() {
        return $this->hasMany(JadwalKuliah::class, "nip", "nip");
    }

    public function user()
    {
        // Asumsi: foreign key di tabel dosens adalah 'user_id'
        return $this->belongsTo(User::class);
    }
}
