<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    protected $fillable = ['no_mohon', 'kd_ktm', 'kd_smkl', 'no_surat', 'tgl_surat', 'perihal',  'utk_satuan', 'nm_domain', 'status', 'klasifikasi', 'melalui',  'file_surat', 'id_domain', 'user_id'];
    protected $table = 'permohonans';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
