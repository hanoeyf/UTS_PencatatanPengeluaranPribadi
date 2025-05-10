<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    protected $table = 'm_level'; // nama tabel

    protected $primaryKey = 'level_id'; // primary key

    protected $fillable = ['level_kode', 'level_nama']; // kolom yang bisa diisi
}
