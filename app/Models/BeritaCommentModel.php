<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaCommentModel extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'berita_comment';

    // Menentukan primary key kustom
    protected $primaryKey = 'id_com';

    // Kolom-kolom yang diizinkan untuk Mass Assignment
    protected $fillable = [
        'id_br',
        'nama',
        'email',
        'sosmed',
        'isi',
        'reply',
    ];

    /**
     * Relasi ke BeritaModel (Many to One)
     * Setiap komentar dimiliki oleh satu berita
     */
    public function berita()
    {
        return $this->belongsTo(BeritaModel::class, 'id_br', 'id_br');
    }
}
