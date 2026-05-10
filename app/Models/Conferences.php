<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conferences extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'conferences';

    // Nama primary key yang digunakan
    protected $primaryKey = 'id_conf';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'nama_conf',
        'tgl_mulai',
        'tgl_selesai',
        'deadline_subm',
        'link_zoom',
    ];

    // Mengatur agar tgl otomatis menjadi instance Carbon
    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'deadline_subm' => 'date',
    ];

    //relasi ke kategori
    // app/Models/Conferences.php

    public function kategoris()
    {
        // Foreign Key: id_conf, Local Key: id_conf
        return $this->hasMany(Kategori::class, 'id_conf', 'id_conf');
    }

    public function pendaftar()
    {
        return $this->hasManyThrough(
            PesertaConferences::class, // Target (Model akhir yang ingin dihitung)
            Kategori::class,           // Through (Model jembatan)
            'id_conf',                 // FK di tabel Kategori (merujuk ke Conferences)
            'id_ktg',                  // FK di tabel PesertaConferences (merujuk ke Kategori)
            'id_conf',                 // Local key di tabel Conferences
            'id_ktg'                   // Local key di tabel Kategori
        );
    }
}