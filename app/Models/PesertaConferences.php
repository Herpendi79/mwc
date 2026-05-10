<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesertaConferences extends Model
{
    use HasFactory;

    protected $table = 'peserta_conferences';
    protected $primaryKey = 'id_pc';

    protected $fillable = [
        'id',
        'id_ktg',
        'no_sertifikat',
        'file_kp',
        'file_abstract',
        'status_abstract',
        'id_pub',
        'file_artikel',
        'status_artikel',
        'file_bukti_tf',
        'payment',
        'snap',
        'order_id',
    ];

    /**
     * Relasi balik ke Peserta
     */
    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class, 'id', 'id');
    }

    /**
     * Relasi ke Kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_ktg', 'id_ktg');
    }

    public function publikasi()
    {
        return $this->belongsTo(Publikasi::class, 'id_pub', 'id_pub');
    }
}
