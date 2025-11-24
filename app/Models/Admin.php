<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';
    // ID standar (integer auto increment), jadi tidak perlu konfigurasi khusus
    
    protected $fillable = [
        'username',
        'password',
    ];
    
    // Sembunyikan password agar tidak ikut tertarik saat query JSON
    protected $hidden = [
        'password',
    ];
}