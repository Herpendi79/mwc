<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesertaRoanModel extends Model
{
    protected $table = 'roan_peserta';
    protected $primaryKey = 'id_rp'; // Menentukan primary key custom
    protected $fillable = ['name', 'alamat', 'email', 'telpon', 'id_ro'];

    /**
     * Relasi ke RoanModel
     * Seorang peserta milik satu kegiatan Roan
     */
    public function roan(): BelongsTo
    {
        return $this->belongsTo(RoanModel::class, 'id_ro', 'id_ro');
    }
}
