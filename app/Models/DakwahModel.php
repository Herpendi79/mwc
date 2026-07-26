<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DakwahModel extends Model
{
    protected $table = 'dakwah';
    protected $primaryKey = 'id_pd';
    protected $fillable = ['judul', 'kategori', 'mubaligh', 'isi', 'tgl', 'status', 'poster', 'link_yt'];
}
