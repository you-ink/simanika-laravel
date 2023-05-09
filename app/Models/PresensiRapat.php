<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiRapat extends Model
{
    use HasFactory;

    protected $table = 'presensi_rapats';
    protected $fillable = [
        'waktu_hadir',
        'foto',
        'peran',
        'rapat_id',
        'user_id'
    ];
}
