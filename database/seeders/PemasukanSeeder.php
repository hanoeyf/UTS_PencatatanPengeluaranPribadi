<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemasukanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pemasukan')->insert([
            [
                'nama' => 'Gaji Les 1',
                'jumlah' => 150000,
                'asal' => 'Gaji',
                'tanggal' => Carbon::parse('2025-04-01'),
                'saldo' => 150000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Gaji Les 2',
                'jumlah' => 105000,
                'asal' => 'Gaji',
                'tanggal' => Carbon::parse('2025-04-03'),
                'saldo' => 255000, // Total setelah ditambah
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
