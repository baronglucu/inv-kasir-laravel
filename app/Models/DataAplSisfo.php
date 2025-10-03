<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataAplSisfo extends Model
{
    protected $fillable = ['id', 'id_apl', 'nama_apl', 'ip_add', 'nm_dom', 'status', 'thn_ada', 'tgl_aktif', 'kd_ktm', 'kd_smkl', 'lkt', 'jaringan', 'fungsi', 'id_mitra', 'keterangan', 'user_id'];
}
