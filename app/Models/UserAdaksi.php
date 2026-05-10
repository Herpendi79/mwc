<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAdaksi extends Model
{
    // Merujuk ke tabel 'users' milik pendaftaran ADAKSI
    protected $table = 'users';

    // Primary Key sesuai struktur tabel ADAKSI Anda
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'email',
        'role',
        'no_hp',
    ];

    /**
     * Relasi ke tabel Anggota (ADAKSI)
     */
    public function anggota()
    {
        // Sesuaikan nama Model Anggota Anda, misal AnggotaModel
        return $this->hasOne(AnggotaModel::class, 'id_user', 'id_user');
    }
}
