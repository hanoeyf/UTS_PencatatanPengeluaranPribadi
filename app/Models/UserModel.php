<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Authenticatable
{
    use Notifiable;

    protected $table = 'm_user'; // nama tabel
    protected $primaryKey = 'user_id'; // primary key

    protected $fillable = [
        'username',
        'nama',
        'password',
        'level_id', // pastikan ini ada kalau pakai relasi
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke model Level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
    public function getRoleName():string
    {
        return $this->level->level_nama;
    }
    public function hasRole($role):bool
    {
        return $this->level->level_kode == $role;
    }
    // public function getRole()
    // {
    //     return $this->level->level_kode;
    // }
}
