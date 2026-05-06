<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Import ini
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable implements MustVerifyEmail // Tambahkan implements
{
    use HasFactory, Notifiable;

    // Definisikan nama tabel secara eksplisit
    protected $table = 'users_iciphe';

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke tabel peserta
     */
    public function peserta(): HasOne
    {
        return $this->hasOne(Peserta::class, 'user_id');
    }
}
