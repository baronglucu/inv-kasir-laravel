<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbWhm extends Model
{
    protected $table = 'tb_whms';
    protected $fillable = ['ip_address', 'nama_whm', 'kodeRak', 'kapasitas', 'kondisi', 'tgl_aktif', 'tgl_akhir', 'lama_ssl', 'keterangan', 'user_id'];
}
