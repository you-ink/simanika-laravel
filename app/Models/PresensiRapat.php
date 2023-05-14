<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /**
     * Get the user that owns the Artikel
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
