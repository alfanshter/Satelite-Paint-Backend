<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cicilan extends Model
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
        'jatuhtempo1',
        'jatuhtempo2',
        'jatuhtempo3',
        'jatuhtempo4',
        'statuscicilan',
        'hargacicilan',
        'jumlahcicilan',
        'idusers',
        'foto'
    ];
}
