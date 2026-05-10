<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}