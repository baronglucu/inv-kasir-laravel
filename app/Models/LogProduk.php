<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogProduk extends Model
{
    protected $fillable = ['serialNumber', 'kon_lama', 'kon_baru', 'kodeRak', 'UserId'];
}
