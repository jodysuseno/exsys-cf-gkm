<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'nomor_kartu_identitas',
        'nama',
        'umur',
        'phone',
    ];

    public function basis_pengetahuan()
    {
        return $this->hasMany(BasisPengetahuan::class);
    }
    public function kasus()
    {
        return $this->hasMany(Kasus::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
