<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Penghuni extends Model
{
    protected $table = 'penghunis';
    protected $primaryKey = 'id_penghuni';
    protected $fillable = ['id_user', 'nik', 'no_telepon', 'alamat', 'kontak_darurat'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}