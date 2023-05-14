<?php

namespace App\Models;

use App\Models\Divisi;
use App\Models\PresensiRapat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rapat extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'waktu_mulai', 'notulensi', 'nama', 'tipe', 'divisi_id'
    ];

    /**
     * Get the user that owns the Rapat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
    }

    /**
     * Get all of the presensi for the Rapat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function presensi(): HasMany
    {
        return $this->hasMany(PresensiRapat::class, 'rapat_id', 'id');
    }

}
