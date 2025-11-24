<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';
    
    // Konfigurasi Primary Key String (M0001, dst)
    protected $primaryKey = 'kode_bk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_bk',
        'nama',
        'qty',
        'satuan',
        'harga',
        'tanggal',
    ];
}