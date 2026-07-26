<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RelawanModel extends Model
{
    protected $table = 'relawan';
    protected $primaryKey = 'id_re';
    protected $fillable = ['judul', 'lokasi', 'tgl', 'koordinator', 'jml_korban', 'bantuan', 'deskripsi','poster', 'foto'];

    public function peserta(): HasMany
    {
        return $this->hasMany(PesertaRelawanModel::class, 'id_re', 'id_re');
    }
}
