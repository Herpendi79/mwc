<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peserta extends Model
{
    protected $table = 'peserta';

    protected $fillable = [
        'user_id',
        'nama',
        'negara',
        'no_wa',
        'status'
    ];

    /**
     * Relasi balik ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
