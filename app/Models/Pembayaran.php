<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $primaryKey = 'id_pembayaran';

    public function getRouteKeyName(): string
    {
        return 'id_pembayaran';
    }

    protected $fillable = [
        'id_user',
        'bulan',
        'nominal',
        'bukti_pembayaran',
        'status',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
            'verified_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
