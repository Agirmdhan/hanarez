<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kamar extends Model
{
    protected $table = 'kamars';
    protected $primaryKey = 'id_kamar';
    protected $fillable = ['nomor_kamar', 'tipe', 'harga', 'fasilitas', 'status'];

    public function penghuni(): HasOne
    {
        return $this->hasOne(User::class, 'id_kamar', 'id_kamar')
            ->where('role', 'penghuni');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_kamar', 'id_kamar');
    }

    public function laporans(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_kamar', 'id_kamar');
    }

    public static function ensureDefaultRooms(): void
    {
        for ($number = 1; $number <= 6; $number++) {
            static::firstOrCreate(
                ['nomor_kamar' => (string) $number],
                [
                    'tipe' => 'Standar',
                    'harga' => 0,
                    'status' => 'Tersedia',
                ],
            );
        }
    }
}
