<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomProduk extends Model
{
    use HasFactory;

    protected $table = 'bom_produk';
    
    public $timestamps = false;


    protected $fillable = [
        'kode_bom',
        'kode_bk',
        'kode_produk',
        'nama_produk',
        'kebutuhan',
    ];
}