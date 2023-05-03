<?php

namespace App\Models;

use App\Models\User;
use App\Models\Divisi;
use App\Models\ArtikelFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'konten', 'sampul', 'user_id', 'divisi_id'
    ];

    /**
     * Get the user that owns the Artikel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the user that owns the Artikel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
    }

    /**
     * Get all of the file for the Artikel
     *
     * @return HasMany
     */
    public function file(): HasMany
    {
        return $this->hasMany(ArtikelFile::class, 'artikel_id', 'id');
    }

}
