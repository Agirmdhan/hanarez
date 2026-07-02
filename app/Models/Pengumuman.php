<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    protected $table = 'pengumumen';
    protected $primaryKey = 'id_pengumuman';

    protected $fillable = [
        'id_user',
        'judul',
        'konten',
        'tanggal_expired',
    ];

    protected $casts = [
        'tanggal_expired' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Scope untuk pengumuman yang masih berlaku (belum expired).
     */
    public function scopeAktif($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('tanggal_expired')
              ->orWhere('tanggal_expired', '>=', now()->format('Y-m-d'));
        });
    }
}