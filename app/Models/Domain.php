<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['nama_domain', 'hosting', 'framework', 'status', 'id_whm', 'tgl_aktif', 'kd_ktm', 'kd_smkl', 'keterangan', 'user_id'];
}
