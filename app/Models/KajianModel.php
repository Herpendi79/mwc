<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KajianModel extends Model
{
    use HasFactory;

    protected $table = 'kajian';

    protected $fillable = [
        'judul',
        'tema',
        'tanggal',
        'pemateri',
        'lokasi',
        'deskripsi',
        'materi',
        'poster',
        'foto',
        'link_yt',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
    
}
