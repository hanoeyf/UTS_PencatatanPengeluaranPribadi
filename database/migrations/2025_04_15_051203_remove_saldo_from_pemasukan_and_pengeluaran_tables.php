<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });

        Schema::table('pengeluaran', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });
    }

    public function down(): void
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            $table->decimal('saldo', 15, 3)->nullable();
        });

        Schema::table('pengeluaran', function (Blueprint $table) {
            $table->decimal('saldo', 15, 3)->nullable();
        });
    }
};
