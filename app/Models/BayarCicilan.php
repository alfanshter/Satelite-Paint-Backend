<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayarCicilan extends Model
{
    use HasFactory;
    protected $fillable= [
        'nomorpesanan',
        'jumlahbayar',
        'jatuhtempo',
        'status'
    ];
}
