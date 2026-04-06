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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->unique()->constrained('peminjaman')->onDelete('cascade');
            $table->date('tanggal_kembali_aktual');
            $table->enum('kondisi_alat', ['baik', 'rusak_ringan', 'rusak_berat']);
            $table->decimal('denda', 10, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->foreignId('processed_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
