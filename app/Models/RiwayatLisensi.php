<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatLisensi extends Model
{
    protected $fillable = ['serialNumber', 'no_invoice', 'tgl_transaksi', 'tgl_lisensi', 'tgl_berakhir', 'status', 'idpenyedia', 'idnorek', 'harga', 'user_id', 'keterangan'];
}
