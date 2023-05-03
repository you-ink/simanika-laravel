<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailUser extends Model
{
    use HasFactory;

    protected $table = 'detail_users';
    protected $fillable = [
        'foto',
        'bukti_kesanggupan',
        'bukti_mahasiswa',
        'tanggal_wawancara',
        'waktu_wawancara',
        'user_id',
        'divisi_id',
        'jabatan_id',
    ];
}
