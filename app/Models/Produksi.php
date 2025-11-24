<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    use HasFactory;

    protected $table = 'produksi';
    protected $primaryKey = 'id_order'; // Sesuai migrasi

    protected $fillable = [
        'invoice',
        'kode_customer',
        'kode_produk',
        'nama_produk',
        'qty',
        'harga',
        'status',
        'tanggal',
        'provinsi',
        'kota',
        'alamat',
        'kode_pos',
        'terima',
        'tolak',
        'cek',
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'kode_customer', 'kode_customer');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }
}