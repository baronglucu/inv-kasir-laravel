<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbjenis extends Model
{
    use HasFactory;
    protected $fillable = ['id','kode_jns','nama_jns'];
}
