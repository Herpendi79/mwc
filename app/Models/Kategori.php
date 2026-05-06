<?php

namespace App\Models; // Pastikan namespace-nya persis seperti ini

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_ktg';

    protected $fillable = [
        'nama_ktg',
        'jenis',
        'domisili',
        'fee',
        'id_conf',
    ];

    public function conference(): BelongsTo
    {
        // Nama fungsi sebaiknya singular 'conference' karena belongsTo
        return $this->belongsTo(Conferences::class, 'id_conf', 'id_conf');
    }

    /**
     * Relasi ke PesertaConferences (One to Many)
     * Satu kategori bisa dimiliki oleh banyak pendaftar/peserta
     */
    public function pesertaConferences(): HasMany
    {
        return $this->hasMany(PesertaConferences::class, 'id_ktg', 'id_ktg');
    }
}
