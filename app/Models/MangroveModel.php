<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangroveModel extends Model
{
    use HasFactory;

    protected $table = 'mangrove';

    protected $fillable = [
        'donatur',
        'email',
        'jumlah_infaq',
        'bukti_tf',
        'jumlah_pohon',
        'pembayaran',
        'tanggal',
        'no_sertifikat',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_infaq' => 'decimal:2',
    ];
}
