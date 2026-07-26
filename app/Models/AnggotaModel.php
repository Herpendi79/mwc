<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    protected $fillable = ['user_id','no_anggota', 'alamat','foto', 'telpon', 'status', 'keterangan'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
