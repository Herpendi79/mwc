<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaHalaqahModel extends Model
{
    use HasFactory;

    protected $table = 'halaqah_peserta';
    protected $primaryKey = 'id_ph';

    protected $fillable = [
        'name',
        'alamat',
        'email',
        'telpon',
        'id', // Relasi ke user
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
