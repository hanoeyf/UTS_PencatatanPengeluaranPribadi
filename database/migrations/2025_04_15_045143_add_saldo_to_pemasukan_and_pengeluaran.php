<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menambahkan kolom saldo pada tabel pemasukan
        Schema::table('pemasukan', function (Blueprint $table) {
            $table->decimal('saldo', 15, 3)->default(0); // Menambahkan kolom saldo
        });

        // Menambahkan kolom saldo pada tabel pengeluaran
        Schema::table('pengeluaran', function (Blueprint $table) {
            $table->decimal('saldo', 15, 3)->default(0); // Menambahkan kolom saldo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });

        // Menghapus kolom saldo dari tabel pengeluaran
        Schema::table('pengeluaran', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });
    }
};
