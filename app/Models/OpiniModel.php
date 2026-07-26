<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpiniModel extends Model
{
    protected $table = 'opinis';
    protected $primaryKey = 'id_op';
    protected $fillable = ['judul', 'kategori', 'penulis', 'ringkasan', 'isi', 'foto', 'lampiran', 'status'];
}
