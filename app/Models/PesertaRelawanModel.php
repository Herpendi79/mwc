<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesertaRelawanModel extends Model
{
    protected $table = 'relawan_peserta';
    protected $primaryKey = 'id_rp';
    protected $fillable = ['name', 'alamat', 'email', 'telpon', 'id_re'];

    public function relawan(): BelongsTo
    {
        return $this->belongsTo(RelawanModel::class, 'id_re', 'id_re');
    }
}
