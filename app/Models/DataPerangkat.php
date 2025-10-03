<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPerangkat extends Model
{
    protected $fillable = ['serialNumber', 'merk', 'model', 'kapasitas', 'storage', 'kode_jns', 'kodeRak', 'ip_address', 'tgl_aktif', 'kondisi', 'sistemOperasi', 'status', 'peruntukan', 'keterangan', 'id_mitra', 'id_apl', 'kd_ktm', 'kd_smkl', 'user_id'];
}
