<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengeluaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengeluaran')->insert([
            [
                'nama' => 'Belanja Bulanan',
                'jumlah' => 90000,
                'tujuan' => 'SuperIndo',
                'kategori' => ' Belanja',
                'tanggal' => Carbon::parse('2025-04-05'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Makan di Luar',
                'jumlah' => 25000,
                'tujuan' => 'Restoran',
                'kategori' => 'Makanan',
                'tanggal' => Carbon::parse('2025-04-06'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
