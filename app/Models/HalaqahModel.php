<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HalaqahModel extends Model
{
    use HasFactory;

    protected $table = 'halaqah';
    protected $primaryKey = 'id';

    protected $fillable = [
        'judul',
        'tema',
        'tanggal',
        'narsum',
        'moderator',
        'lokasi',
        'deskripsi',
        'hasil',
        'status',
        'thumbnail',
        'foto',
        'link_yt',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Relasi ke Peserta Halaqah (One to Many)
     */
    public function peserta()
    {
        return $this->hasMany(PesertaHalaqahModel::class, 'id', 'id');
    }
}
