<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'user_id',
        'penyakit_id',
        'similarity',
        'status',
    ];

    public function basis_pengetahuan_kompleksitas()
    {
        return $this->hasMany(BasisPengetahuanKompleksitas::class);
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
