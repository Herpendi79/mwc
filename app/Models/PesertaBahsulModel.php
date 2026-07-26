<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaBahsulModel extends Model
{
    use HasFactory;

    protected $table = 'bahsul_peserta';

    // Karena primary key bukan 'id' standar Laravel
    protected $primaryKey = 'id_bsp';

    protected $fillable = [
        'name',
        'alamat',
        'email',
        'telpon',
        'id_bs',
    ];

    /**
     * Relasi ke tabel Bahsul (Many to One)
     */
    public function bahsul()
    {
        return $this->belongsTo(BahsulModel::class, 'id_bs', 'id_bs');
    }
}
