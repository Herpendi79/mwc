<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scope extends Model
{
    use HasFactory;

    protected $table = 'scope';
    protected $primaryKey = 'id_sc'; // Definisi Primary Key custom

    protected $fillable = [
        'nama_sc',
        'id_conf',
    ];

    /**
     * Relasi ke tabel Conference
     */
    public function conference(): BelongsTo
    {
        // Parameter: Model, Foreign Key di tabel scope, Owner Key di tabel conference
        return $this->belongsTo(Conferences::class, 'id_conf', 'id_conf');
    }

    /**
     * Relasi ke pendaftaran (PesertaConferences)
     */
    public function pendaftaran(): HasMany
    {
        return $this->hasMany(PesertaConferences::class, 'id_sc', 'id_sc');
    }
}
