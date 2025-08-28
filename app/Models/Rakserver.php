<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rakserver extends Model
{
    use HasFactory;
    protected $fillable = ['kodeRak', 'namaRak', 'model', 'kdjenis', 'kapasitas', 'keterangan'];
}
