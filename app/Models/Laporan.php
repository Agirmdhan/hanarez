<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    protected $table = 'laporans';
    protected $primaryKey = 'id_laporan';

    public function getRouteKeyName(): string
    {
        return 'id_laporan';
    }

    protected $fillable = [
        'id_user',
        'id_kamar',
        'judul',
        'deskripsi',
        'foto',
        'status',
    ];

    protected $casts = [
        'foto' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }
}
