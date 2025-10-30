<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- Ganti ini
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable  // <-- Ganti ini
{
    use HasFactory, Notifiable;

    protected $table = 'customer'; // <-- Tambahkan ini
    protected $primaryKey = 'kode_customer'; // <-- Tambahkan ini
    public $incrementing = false; // <-- Tambahkan ini
    protected $keyType = 'string'; // <-- Tambahkan ini

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_customer',
        'nama',
        'email',
        'username',
        'password',
        'telp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
}