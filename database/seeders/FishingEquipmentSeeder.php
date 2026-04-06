<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Alat;

class FishingEquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriJoran = Kategori::firstOrCreate(['nama_kategori' => 'Joran Pancing']);
        $kategoriReel = Kategori::firstOrCreate(['nama_kategori' => 'Reel']);
        $kategoriUmpan = Kategori::firstOrCreate(['nama_kategori' => 'Umpan & Lure']);
        $kategoriAksesori = Kategori::firstOrCreate(['nama_kategori' => 'Aksesori Pancing']);
        $kategoriTackle = Kategori::firstOrCreate(['nama_kategori' => 'Tackle Box']);

        Alat::updateOrCreate(
            ['kode_alat' => 'JRN-001'],
            [
                'nama_alat' => 'Joran Shimano FX 6ft',
                'kategori_id' => $kategoriJoran->id,
                'stok_total' => 10,
                'stok_tersedia' => 8,
                'kondisi' => 'baik',
                'deskripsi' => 'Spinning rod 6 kaki untuk pemula. Action Medium, Line weight 4-10lb',
                'harga_sewa_per_hari' => 25000
            ]
        );

        Alat::updateOrCreate(
            ['kode_alat' => 'JRN-002'],
            [
                'nama_alat' => 'Joran Daiwa Saltist 7ft',
                'kategori_id' => $kategoriJoran->id,
                'stok_total' => 5,
                'stok_tersedia' => 3,
                'kondisi' => 'baik',
                'deskripsi' => 'Heavy action untuk mancing laut. Line weight 15-30lb, cocok untuk gabus',
                'harga_sewa_per_hari' => 50000
            ]
        );

        Alat::updateOrCreate(
            ['kode_alat' => 'JRN-003'],
            [
                'nama_alat' => 'Joran Abu Garcia Veritas 6.5ft',
                'kategori_id' => $kategoriJoran->id,
                'stok_total' => 8,
                'stok_tersedia' => 8,
                'kondisi' => 'baik',
                'deskripsi' => 'Medium heavy untuk casting, responsif dan ringan',
                'harga_sewa_per_hari' => 40000
            ]
        );

        Alat::updateOrCreate(
            ['kode_alat' => 'REEL-001'],
            [
                'nama_alat' => 'Reel Shimano FX 2500',
                'kategori_id' => $kategoriReel->id,
                'stok_total' => 12,
                'stok_tersedia' => 10,
                'kondisi' => 'baik',
                'deskripsi' => 'Spinning reel 2500, ball bearing 3+1, gear ratio 5.0:1',
                'harga_sewa_per_hari' => 20000
            ]
        );

        Alat::updateOrCreate(
            ['kode_alat' => 'REEL-002'],
            [
                'nama_alat' => 'Reel Baitcasting Daiwa',
                'kategori_id' => $kategoriReel->id,
                'stok_total' => 6,
                'stok_tersedia' => 4,
                'kondisi' => 'baik',
                'deskripsi' => 'Baitcasting dengan magnetic brake, gear ratio 7.1:1',
                'harga_sewa_per_hari' => 35000
            ]
        );

        Alat::updateOrCreate(
            ['kode_alat' => 'LURE-001'],
            [
                'nama_alat' => 'Set Crankbait 10pcs',
                'kategori_id' => $kategoriUmpan->id,
                'stok_total' => 15,
                'stok_tersedia' => 12,
                'kondisi' => 'baik',
                'deskripsi' => 'Paket crankbait berbagai warna untuk bass dan gabus',
                'harga_sewa_per_hari' => 15000
            ]
        );

        Alat::updateOrCreate(
            ['kode_alat' => 'LURE-002'],
            [
                'nama_alat' => 'Set Popper & Pencil',
                'kategori_id' => $kategoriUmpan->id,
                'stok_total' => 10,
                'stok_tersedia' => 8,
                'kondisi' => 'baik',
                'deskripsi' => 'Umpan topwater efektif pagi dan sore hari',
                'harga_sewa_per_hari' => 12000
            ]
        );

        Alat::updateOrCreate(
            ['kode_alat' => 'AKS-001'],
            [
                'nama_alat' => 'Senar PE Line 20lb',
                'kategori_id' => $kategoriAksesori->id,
                'stok_total' => 25,
                'stok_tersedia' => 20,
                'kondisi' => 'baik',
                'deskripsi' => 'Braided PE line 150m, kuat dan tahan lama',
                'harga_sewa_per_hari' => 8000
            ]
        );

        Alat::updateOrCreate(
            ['kode_alat' => 'AKS-002'],
            [
                'nama_alat' => 'Set Hook Assorted',
                'kategori_id' => $kategoriAksesori->id,
                'stok_total' => 30,
                'stok_tersedia' => 25,
                'kondisi' => 'baik',
                'deskripsi' => 'Mata kail berbagai ukuran #2-#10, 100pcs',
                'harga_sewa_per_hari' => 5000
            ]
        );

        Alat::updateOrCreate(
            ['kode_alat' => 'TKL-001'],
            [
                'nama_alat' => 'Tackle Box Premium',
                'kategori_id' => $kategoriTackle->id,
                'stok_total' => 12,
                'stok_tersedia' => 8,
                'kondisi' => 'baik',
                'deskripsi' => 'Kotak pancing 5 laci, anti air, ukuran 35x20x18cm',
                'harga_sewa_per_hari' => 10000
            ]
        );

        Alat::updateOrCreate(
            ['kode_alat' => 'TKL-002'],
            [
                'nama_alat' => 'Tas Ransel Pancing 40L',
                'kategori_id' => $kategoriTackle->id,
                'stok_total' => 10,
                'stok_tersedia' => 7,
                'kondisi' => 'baik',
                'deskripsi' => 'Tas punggung waterproof dengan tempat joran',
                'harga_sewa_per_hari' => 15000
            ]
        );
    }
}
