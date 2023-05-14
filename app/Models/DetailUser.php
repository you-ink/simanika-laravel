<?php

namespace App\Models;

use App\Models\User;
use App\Models\Divisi;
use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    /**
     * Get the user that owns the DetailUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
    }

    /**
     * Get the user that owns the DetailUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }
}
