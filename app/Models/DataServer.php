<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataServer extends Model
{
    protected $fillable = ['serialNumber', 'merk', 'model', 'kapasitas', 'kodeRak', 'ip_address', 'tgl_aktif', 'kondisi', 'sistemOperasi', 'status', 'peruntukan', 'keterangan', 'id_mitra', 'kd_ktm', 'kd_smkl', 'user_id']; 
}
