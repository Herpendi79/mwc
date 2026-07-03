<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewArticle extends Model
{
    protected $table = 'review_article';
    protected $primaryKey = 'id_rev';
    protected $fillable = ['id_global', 'nama_file', 'ket'];

    // Relasi ke tabel peserta_conferences
    public function pesertaConference()
    {
        return $this->belongsTo(PesertaConferences::class, 'no_sertif', 'no_sertif');
    }

    // Relasi ke tabel peserta_conferences_adaksi
    public function pesertaAdaksi()
    {
        return $this->belongsTo(PesertaConferencesAdaksi::class, 'no_sertif', 'no_sertif');
    }
}
