<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukCheckout extends Model
{
    use HasFactory;

    protected $fillable = [
        'idproduk',
        'nama',
        'nomorwa',
        'foto',
        'deskripsi',
        'harga',
        'jumlah'
    ];
}
