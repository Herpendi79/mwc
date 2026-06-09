<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    use HasFactory;

    protected $table = 'publikasi';
    protected $primaryKey = 'id_pub';

    protected $fillable = [
        'nama_pub',
        'index',
        'apc',
        'template',
    ];

    /**
     * Relasi One-to-Many ke PesertaConferences
     * Satu publikasi (misal Jurnal A) bisa dipilih oleh banyak peserta_conferences.
     */
    public function pesertaConferences()
    {
        return $this->hasMany(PesertaConferences::class, 'id_pub', 'id_pub');
    }
    public function pesertaConferencesAdaksi()
    {
        return $this->hasMany(PesertaConferencesAdaksi::class, 'id_pub', 'id_pub');
    }
}
