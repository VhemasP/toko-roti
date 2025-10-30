<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Nama tabel
    protected $primaryKey = 'kode_produk'; // Primary key
    public $incrementing = false; // Primary key bukan auto-increment
    protected $keyType = 'string'; // Tipe data primary key
    public $timestamps = false; // Tabel ini tidak punya created_at/updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_produk',
        'nama',
        'image',
        'deskripsi',
        'harga',
    ];
}