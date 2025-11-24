<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Gunakan ini dulu. Nanti jika pakai Auth, ganti ke Authenticatable

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    
    // Konfigurasi Primary Key String (C0001, dst)
    protected $primaryKey = 'kode_customer';
    public $incrementing = false;
    protected $keyType = 'string';

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