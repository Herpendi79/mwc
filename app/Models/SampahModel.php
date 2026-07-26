<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampahModel extends Model
{
    protected $table = 'sampahs';
    protected $primaryKey = 'id_sm';

    protected $fillable = [
        'penyetor',
        'jenis',
        'berat',
        'nilai',
        'tgl',
        'petugas',
        'ket',
        'foto'
    ];
}
