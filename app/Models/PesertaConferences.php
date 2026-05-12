<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// File: app/Models/PesertaConferences.php

class PesertaConferences extends Model
{
    protected $table = 'peserta_conferences';
    protected $primaryKey = 'id_pc';

    protected $fillable = [
        'user_id', // Ubah dari 'id' menjadi 'user_id'
        'id_ktg',
        'id_sc',
        'id_pub',
        'no_sertifikat',
        'file_kp',
        'file_abstract',
        'status_abstract',
        'file_artikel',
        'status_artikel',
        'file_bukti_tf',
        'payment',
        'id_sc',
        'snap',
        'order_id',
    ];

    /**
     * Relasi balik LANGSUNG ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_ktg', 'id_ktg');
    }
    public function publikasi()
    {
        // Parameter: Model tujuan, foreign key di pendaftaran, primary key di publikasi
        return $this->belongsTo(Publikasi::class, 'id_pub', 'id_pub');
    }
}
