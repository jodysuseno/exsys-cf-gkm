<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasisPengetahuan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'kasus_id',
        'gejala_id',
        'bobot_gejala_id',
    ];

    public function kasus()
    {
        return $this->belongsTo(Pasien::class);
    }
    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
    public function bobot_gejala()
    {
        return $this->belongsTo(BobotGejala::class);
    }
}
