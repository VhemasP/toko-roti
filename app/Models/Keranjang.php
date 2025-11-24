<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang'; 
    protected $primaryKey = 'id_keranjang';

    public $timestamps = false;

    protected $fillable = [
        'kode_customer',
        'kode_produk',
        'nama_produk',
        'qty',
        'harga',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }
}