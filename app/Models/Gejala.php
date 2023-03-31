<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $fillable = [
        'bobot_gejala_id',
        'kode',
        'nama',
    ];

    public function basis_pengetahuan()
    {
        return $this->hasMany(BasisPengetahuan::class);
    }
    public function bobot_gejala()
    {
        return $this->belongsTo(BobotGejala::class);
    }
}
