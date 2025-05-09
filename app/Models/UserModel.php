<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserModel extends Authenticatable
{
    use Notifiable;

    protected $table = 'm_user'; // nama tabel
    protected $primaryKey = 'user_id'; // primary key

    protected $fillable = [
        'username',
        'nama',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
