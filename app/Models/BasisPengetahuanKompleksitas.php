<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasisPengetahuanKompleksitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'kasus_id',
        'kompleksitas_id'
    ];

    public function kasus()
    {
        return $this->belongsTo(Kasus::class);
    }

    public function kompleksitas()
    {
        return $this->belongsTo(BobotKompleksitas::class);
    }

}
