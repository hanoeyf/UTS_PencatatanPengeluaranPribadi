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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Gaji Les 2',
                'jumlah' => 105000,
                'asal' => 'Gaji',
                'tanggal' => Carbon::parse('2025-04-03'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
