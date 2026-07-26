<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BencanaModel extends Model
{
    protected $table = 'bencana';
    protected $primaryKey = 'id_lb';
    protected $fillable = ['pelapor', 'jenis_bencana', 'lokasi', 'tgl', 'deskripsi', 'kebutuhan', 'jml_korban', 'foto','status'];
}
