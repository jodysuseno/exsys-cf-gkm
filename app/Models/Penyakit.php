<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'definisi',
        'solusi',
    ];

    public function basis_pengetahuan()
    {
        return $this->hasMany(BasisPengetahuan::class);
    }
    public function kasus()
    {
        return $this->hasMany(Kasus::class);
    }
}
