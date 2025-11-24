<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer'; // Nama tabel lama
    
    protected $primaryKey = 'kode_customer';
    public $incrementing = false; // Karena ID bukan auto-increment integer
    protected $keyType = 'string';

    // TAMBAHKAN BARIS INI (Matikan timestamps otomatis)
    public $timestamps = false; 

    protected $fillable = [
        'kode_customer',
        'nama',
        'email',
        'username',
        'password',
        'telp',
    ];
    
    protected $hidden = [
        'password',
    ];
}