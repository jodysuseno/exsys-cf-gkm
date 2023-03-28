<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'bobot_kompleksitas_id',
        'user_id',
        'nama',
        'umur',
        'phone',
        'status'
    ];
}
