<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemasukanModel extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';
    
    protected $fillable = [
        'nama',
        'jumlah',
        'asal',
        'tanggal',
    ];

    protected $primaryKey = 'id'; // sesuai migration

    public $timestamps = true;
}
