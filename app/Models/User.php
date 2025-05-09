<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user'; // nama tabel di database
    protected $primaryKey = 'user_id'; // primary key-nya

    protected $fillable = [
        'username',
        'password',
        'nama',
        'created_at',
        'updated_at',
    ];

    protected $hidden = ['password']; // agar password tidak terlihat di JSON

    protected $casts  = [
        'password' => 'hashed', // otomatis hash password
    ];
}
