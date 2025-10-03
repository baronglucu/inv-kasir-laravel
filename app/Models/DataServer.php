<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataServer extends Model
{
    protected $fillable = ['serialNumber', 'sisops', 'socket', 'core', 'slot', 'bios', 'scsi', 'hdisk', 'descrip']; 
}
