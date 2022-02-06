<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'telepon',
        'alamat',
        'nomorpesanan',
        'metodepembayaran',
        'totalharga',
        'diskon',
        'tanggal',
        'jam',
        'status',
        'idusers',
        'foto'
    ];
}
