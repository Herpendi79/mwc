<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoanModel extends Model
{
    protected $table = 'roans';
    protected $primaryKey = 'id_ro';

    protected $fillable = [
        'judul',
        'tema',
        'tgl',
        'lokasi',
        'pj',
        'vol_sampah',
        'deskripsi',
        'poster',
        'foto'
    ];

    public function peserta(): HasMany
    {
        return $this->hasMany(PesertaRoanModel::class, 'id_ro', 'id_ro');
    }
}
