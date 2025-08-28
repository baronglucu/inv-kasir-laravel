<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbsatminkal extends Model
{
    use HasFactory;

    protected $fillable = ['kd_smkl', 'ur_smkl', 'kd_ktm'];
    protected $table = 'Tbsatminkals';
    public function kotama()
    {
        return $this->belongsTo(Tbkotama::class);
    }
}
