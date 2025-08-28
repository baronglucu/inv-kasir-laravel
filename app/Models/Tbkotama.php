<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbkotama extends Model
{
    use HasFactory;

    protected $fillable = ['kd_ktm', 'ur_ktm'];
    protected $table = 'Tbkotamas';

    public function satuan()
    {
        return $this->hasMany(Tbsatminkal::class);
    }
}
