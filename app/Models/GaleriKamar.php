<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriKamar extends Model
{
    protected $table = 'galeri_kamars';
    protected $primaryKey = 'id_galeri';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'id_user',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}