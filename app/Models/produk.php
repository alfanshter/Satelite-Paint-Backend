<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'nama',
        'foto',
        'deskripsi',
        'stok',
        'mingrosir',
        'maxgrosir',
        'harga',
        'kategori',
        'hargagrosir',
        'rating',
    ];
}
