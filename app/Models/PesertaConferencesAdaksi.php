<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaConferencesAdaksi extends Model
{
    use HasFactory;

    // 1. Definisikan nama tabel secara eksplisit
    protected $table = 'peserta_conferences_adaksi';

    // 2. Definisikan Primary Key (karena bukan 'id')
    protected $primaryKey = 'id_pca';

    // 3. Izinkan mass assignment untuk kolom-kolom berikut
    protected $fillable = [
        'id_user',
        'id_ktg',
        'no_sertifikat',
        'judul',
        'file_abstract',
        'status_abstract',
        'id_pub',
        'file_artikel',
        'status_artikel',
        'payment',
        'id_sc',
        'snap',
        'order_id',
    ];

    /**
     * Relasi ke model User (Pemilik pendaftaran)
     */
    public function user()
    {
        // Arahkan ke model User khusus ADAKSI
        return $this->belongsTo(UserAdaksi::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke model Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_ktg', 'id_ktg');
    }

    /**
     * Relasi ke model Publikasi (Target Journal)
     */
    public function publikasi()
    {
        return $this->belongsTo(Publikasi::class, 'id_pub', 'id_pub');
    }
}
