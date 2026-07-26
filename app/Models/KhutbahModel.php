<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhutbahModel extends Model
{
    protected $table = 'khutbahs';
    protected $primaryKey = 'id_kj';
    protected $fillable = [
        'judul',
        'tema',
        'khatib',
        'masjid',
        'tgl',
        'ringkasan',
        'isi',
        'lampiran',
        'poster'
    ];
}
