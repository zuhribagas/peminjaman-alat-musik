<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Elektronik',
                'deskripsi' => 'Alat-alat elektronik seperti laptop, proyektor, kamera, dll',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Olahraga',
                'deskripsi' => 'Perlengkapan dan alat olahraga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Laboratorium',
                'deskripsi' => 'Peralatan laboratorium untuk praktikum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Alat Musik',
                'deskripsi' => 'Alat musik untuk kegiatan seni dan budaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Perlengkapan Kantor',
                'deskripsi' => 'Peralatan kantor dan administrasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Multimedia',
                'deskripsi' => 'Peralatan multimedia seperti speaker, microphone, dll',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('kategori')->insert($kategoris);
    }
}
