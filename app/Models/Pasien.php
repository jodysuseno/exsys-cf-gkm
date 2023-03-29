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
}
