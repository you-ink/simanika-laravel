<?php

namespace App\Models;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArtikelFile extends Model
{
    use HasFactory;

    protected $table = 'artikel_files';
    protected $fillable = [
        'file',
        'artikel_id',
    ];
}
