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
    protected $casts = [
        'created_at' => 'datetime',
    ];
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
    public function scope()
    {
        return $this->belongsTo(Scope::class, 'id_sc', 'id_sc');
    }
    public function user(): BelongsTo
    {
        // Parameter: Model User, Foreign Key di VIEW, Owner Key di tabel users
        // Jika sumber 'Non ADAKSI', user_id merujuk ke users_iciphe.id
        // Jika sumber 'ADAKSI', id_global (id_pca) merujuk ke users.id_user (lewat logika join di view)

        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
