<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaModel extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit karena menggunakan primary key kustom
    protected $table = 'berita';

    // Menentukan primary key jika bukan 'id' standar Laravel
    protected $primaryKey = 'id_br';

    // Kolom-kolom yang diizinkan untuk Mass Assignment
    protected $fillable = [
        'judul',
        'kategori',
        'penulis',
        'ringkasan',
        'isi',
        'foto',
        'lampiran',
        'status',
    ];

    /**
     * Relasi ke BeritaCommentModel (One to Many)
     * Satu berita memiliki banyak komentar
     */
    public function komentar()
    {
        return $this->hasMany(BeritaCommentModel::class, 'id_br', 'id_br');
    }
}
