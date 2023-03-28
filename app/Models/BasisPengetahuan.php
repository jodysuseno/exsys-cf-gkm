<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasisPengetahuan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pasien_id',
        'penyakit_id',
        'gejala_id',
    ];
}
