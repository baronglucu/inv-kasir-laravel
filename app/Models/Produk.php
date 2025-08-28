<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = ['serialNumber','namaProduk','kodeRak','deskripsi','tgl_pengadaan','kondisi', 'user_id']; 
    
}
