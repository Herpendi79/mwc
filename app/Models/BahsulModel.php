<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahsulModel extends Model
{
    protected $table = 'bahsul';
    protected $primaryKey = 'id_bs';
    protected $fillable = ['judul', 'kategori', 'tanggal', 'lokasi', 'pemohon', 'masalah', 'putusan', 'dasar_hukum', 'status', 'lampiran'];

    public function peserta()
    {
        return $this->hasMany(PesertaBahsulModel::class, 'id_bs', 'id_bs');
    }
    }
