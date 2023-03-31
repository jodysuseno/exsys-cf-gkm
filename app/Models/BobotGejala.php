<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotGejala extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'bobot'
    ];

    public function gejala()
    {
        return $this->hasMany(Gejala::class);
    }

    public function basis_pengetahuan()
    {
        return $this->hasMany(BasisPengetahuan::class);
    }
}
