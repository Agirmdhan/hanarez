<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Menentukan nama primary key sesuai migrasi
    protected $primaryKey = 'id_user';

    // Mendefinisikan kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'name',
        'nama',
        'id_kamar',
        'email',
        'password',
        'role',
        'status',
        'status_pendaftaran',
        'payment_deadline',
        'payment_completed_at',
    ];

    // Menyembunyikan kolom sensitif
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Akses properti name agar dapat menggunakan field nama di database
    public function getNameAttribute(): ?string
    {
        return $this->attributes['nama'] ?? null;
    }

    public function setNameAttribute(string $value): void
    {
        $this->attributes['nama'] = $value;
    }

    public function getIdAttribute(): ?int
    {
        return $this->attributes['id_user'] ?? null;
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_user', 'id_user');
    }

    public function pembayaranBulanIni(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'id_user', 'id_user')
            ->where('bulan', now()->format('Y-m'));
    }

    public function laporans(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_user', 'id_user');
    }

    public function laporanAktif(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_user', 'id_user')
            ->where('status', 'aktif');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
