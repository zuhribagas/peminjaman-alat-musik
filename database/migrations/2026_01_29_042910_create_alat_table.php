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
        Schema::create('alat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('kode_alat', 50)->unique();
            $table->string('nama_alat', 255);
            $table->text('deskripsi')->nullable();
            $table->integer('stok_total')->default(0);
            $table->integer('stok_tersedia')->default(0);
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->string('foto', 255)->nullable();
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['kategori_id', 'stok_tersedia']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
