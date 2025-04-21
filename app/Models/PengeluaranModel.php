<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranModel extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'pengeluaran';

    // Kolom yang bisa diisi
    protected $fillable = [
        'nama',
        'jumlah',
        'tujuan',
        'tanggal',
        'kategori'
    ];
    protected $primaryKey = 'id'; // sesuai migration

    public $timestamps = true;
}
