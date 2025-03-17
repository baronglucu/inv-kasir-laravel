<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenyedia extends Model
{
    protected $fillable = ['id_mitra', 'nama_mitra', 'notelp', 'email', 'alamat', 'kota', 'provinsi', 'alamat_web', 'nama_pimpinan', 'nohp_pimpinan', 'email_pimpinan', 'npwp', 'siup', 'keterangan', 'user_id'];
}
