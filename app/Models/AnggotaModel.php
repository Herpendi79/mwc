<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    protected $fillable = [
        'id_user',
        'nama_anggota',
        'nip_nipppk',
        'status_dosen',
        'homebase_pt',
        'provinsi',
        'foto',
        'status_anggota',
        'snap',
        'order_id',
        'biaya',
        'keterangan',
        'tgl_keanggotaan',
        'bukti_tf_pendaftaran',
        'no_urut',
        'id_card',
        'nama_dpc',
        'kepakaran',
        'cv'
    ];
    protected $casts = [
        'tgl_keanggotaan' => 'datetime',
    ];

    public $timestamps = true;

    /**
     * Get the user that owns the AnggotaModel.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    
    }
    
}
