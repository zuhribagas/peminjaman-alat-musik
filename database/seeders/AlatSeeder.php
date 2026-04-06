<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alats = [
            // Elektronik (kategori_id = 1)
            [
                'kategori_id' => 1,
                'kode_alat' => 'ELK-001',
                'nama_alat' => 'Laptop Dell Latitude 5420',
                'deskripsi' => 'Laptop untuk keperluan presentasi dan pengolahan data',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 1,
                'kode_alat' => 'ELK-002',
                'nama_alat' => 'Proyektor Epson EB-X05',
                'deskripsi' => 'Proyektor untuk presentasi dan pembelajaran',
                'stok_total' => 5,
                'stok_tersedia' => 5,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 1,
                'kode_alat' => 'ELK-003',
                'nama_alat' => 'Kamera Canon EOS 700D',
                'deskripsi' => 'Kamera DSLR untuk dokumentasi kegiatan',
                'stok_total' => 3,
                'stok_tersedia' => 3,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Olahraga (kategori_id = 2)
            [
                'kategori_id' => 2,
                'kode_alat' => 'OLR-001',
                'nama_alat' => 'Bola Sepak',
                'deskripsi' => 'Bola sepak untuk olahraga',
                'stok_total' => 20,
                'stok_tersedia' => 20,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'kode_alat' => 'OLR-002',
                'nama_alat' => 'Bola Basket',
                'deskripsi' => 'Bola basket untuk olahraga',
                'stok_total' => 15,
                'stok_tersedia' => 15,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'kode_alat' => 'OLR-003',
                'nama_alat' => 'Raket Badminton',
                'deskripsi' => 'Raket badminton untuk olahraga',
                'stok_total' => 12,
                'stok_tersedia' => 12,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Laboratorium (kategori_id = 3)
            [
                'kategori_id' => 3,
                'kode_alat' => 'LAB-001',
                'nama_alat' => 'Mikroskop Olympus CX23',
                'deskripsi' => 'Mikroskop untuk praktikum biologi',
                'stok_total' => 8,
                'stok_tersedia' => 8,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'kode_alat' => 'LAB-002',
                'nama_alat' => 'Tabung Reaksi Set',
                'deskripsi' => 'Set tabung reaksi untuk praktikum kimia',
                'stok_total' => 30,
                'stok_tersedia' => 30,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Alat Musik (kategori_id = 4)
            [
                'kategori_id' => 4,
                'kode_alat' => 'MSK-001',
                'nama_alat' => 'Gitar Akustik Yamaha F310',
                'deskripsi' => 'Gitar akustik untuk kegiatan musik',
                'stok_total' => 6,
                'stok_tersedia' => 6,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 4,
                'kode_alat' => 'MSK-002',
                'nama_alat' => 'Keyboard Casio CTK-3500',
                'deskripsi' => 'Keyboard untuk kegiatan musik',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Perlengkapan Kantor (kategori_id = 5)
            [
                'kategori_id' => 5,
                'kode_alat' => 'KTR-001',
                'nama_alat' => 'Printer HP LaserJet Pro',
                'deskripsi' => 'Printer untuk keperluan cetak dokumen',
                'stok_total' => 7,
                'stok_tersedia' => 7,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Multimedia (kategori_id = 6)
            [
                'kategori_id' => 6,
                'kode_alat' => 'MED-001',
                'nama_alat' => 'Speaker Aktif',
                'deskripsi' => 'Speaker aktif untuk acara',
                'stok_total' => 8,
                'stok_tersedia' => 8,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 6,
                'kode_alat' => 'MED-002',
                'nama_alat' => 'Microphone Wireless',
                'deskripsi' => 'Microphone wireless untuk acara',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'kondisi' => 'baik',
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('alat')->insert($alats);
    }
}
