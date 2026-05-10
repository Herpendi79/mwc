<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonitoringPresenter extends Model
{
    // Hubungkan model ke VIEW, bukan ke tabel fisik
    protected $table = 'view_monitoring_presenters';

    // Karena ini view, primary key tidak auto-increment secara standar
    protected $primaryKey = 'id_global';
    public $incrementing = false;

    // View bersifat Read-Only (hanya baca)
    public $timestamps = false;

    /**
     * Relasi ke Kategori tetap bisa digunakan
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_ktg', 'id_ktg');
    }
}
