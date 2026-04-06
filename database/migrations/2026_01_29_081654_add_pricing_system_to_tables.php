<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alat', function (Blueprint $table) {
            $table->decimal('harga_sewa_per_hari', 10, 2)->default(0)->after('deskripsi');
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->integer('durasi_hari')->default(1)->after('tanggal_kembali_rencana');
            $table->decimal('total_biaya_sewa', 10, 2)->default(0)->after('durasi_hari');
            $table->enum('status_pembayaran', ['belum_bayar', 'sudah_bayar'])->default('belum_bayar')->after('total_biaya_sewa');
            $table->timestamp('tanggal_bayar')->nullable()->after('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('alat', function (Blueprint $table) {
            $table->dropColumn('harga_sewa_per_hari');
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['durasi_hari', 'total_biaya_sewa', 'status_pembayaran', 'tanggal_bayar']);
        });
    }
};
