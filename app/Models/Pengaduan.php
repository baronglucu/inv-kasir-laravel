<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = ['no_lapor', 'nama_pelapor', 'tgl_laporan', 'kd_ktm', 'kd_smkl', 'no_telp', 'id_domain', 'masalah', 'solusi', 'status', 'klasifikasi', 'melalui', 'no_surat', 'tgl_surat', 'file_surat', 'user_id'];
    protected $table = 'pengaduans';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
