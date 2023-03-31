<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotKompleksitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'bobot'
    ];

    public function basis_pengetahuan_kompleksitas()
    {
        return $this->hasMany(BasisPengetahuanKompleksitas::class);
    }

    
}
