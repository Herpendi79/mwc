<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany; // Gunakan HasMany, bukan HasManyThrough
// Import model jika diperlukan (opsional jika dalam namespace yang sama)
use App\Models\Peserta;
use App\Models\PesertaConferences;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

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
     * Relasi LANGSUNG ke tabel peserta_conferences
     */
    public function pendaftaran(): HasMany
    {
        // Karena relasinya langsung User -> PesertaConferences, gunakan hasMany
        return $this->hasMany(PesertaConferences::class, 'user_id');
    }

    /**
     * Relasi ke tabel peserta (Jika masih digunakan)
     */
    public function peserta(): HasOne
    {
        return $this->hasOne(Peserta::class, 'user_id');
    }
}
