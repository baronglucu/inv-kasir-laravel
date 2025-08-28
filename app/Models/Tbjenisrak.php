<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbjenisrak extends Model
{
    use HasFactory;
    protected $fillable = ['kdjenis','namaJenis','deskripsi'];

}
