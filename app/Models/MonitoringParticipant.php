<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonitoringParticipant extends Model
{
    protected $table = 'view_monitoring_participants';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_ktg', 'id_ktg');
    }
    public function user(): BelongsTo
    {
        // Parameter: Model User, Foreign Key di VIEW, Owner Key di tabel users_iciphe
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}