<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TblModelServer extends Model
{
    use HasFactory;
    protected $fillable = ['id','kdjenis','kdmodel','namaModel','deskripsi'];
}
