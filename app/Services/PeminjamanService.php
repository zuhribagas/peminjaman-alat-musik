<?php

namespace App\Services;

use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanService
{
    protected $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    private function hitungBiayaSewa(Alat $alat, $tanggalPinjam, $tanggalKembali)
    {
        $durasi = Carbon::parse($tanggalPinjam)->diffInDays(Carbon::parse($tanggalKembali));
        $durasi = max(1, $durasi);
        $totalBiaya = $alat->harga_sewa_per_hari * $durasi;
        
        return [
            'durasi_hari' => $durasi,
            'total_biaya' => $totalBiaya
        ];
    }

    public function approvePeminjaman(Peminjaman $peminjaman)
    {
        try {
            if ($peminjaman->status !== 'pending') {
                throw new \Exception('Peminjaman tidak dalam status pending');
            }

            $alat = $peminjaman->alat;
            if ($alat->stok_tersedia < $peminjaman->jumlah) {
                throw new \Exception('Stok tidak mencukupi');
            }

            $peminjaman->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);

            $alat->update([
                'stok_tersedia' => $alat->stok_tersedia - $peminjaman->jumlah
            ]);

            $this->logService->log('approve_peminjaman', 'Menyetujui peminjaman ID: ' . $peminjaman->id);

            return $peminjaman->fresh();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function rejectPeminjaman(Peminjaman $peminjaman)
    {
        try {
            if ($peminjaman->status !== 'pending') {
                throw new \Exception('Peminjaman tidak dalam status pending');
            }

            $peminjaman->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);

            $this->logService->log('reject_peminjaman', 'Menolak peminjaman ID: ' . $peminjaman->id);

            return $peminjaman->fresh();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function createPeminjaman(array $data)
    {
        try {
            $alat = Alat::findOrFail($data['alat_id']);

            if ($alat->stok_tersedia < $data['jumlah']) {
                throw new \Exception('Stok tidak mencukupi untuk dipinjam');
            }

            $biaya = $this->hitungBiayaSewa(
                $alat,
                $data['tanggal_pinjam'],
                $data['tanggal_kembali_rencana']
            );

            $peminjaman = Peminjaman::create([
                'user_id' => auth()->id(),
                'alat_id' => $data['alat_id'],
                'tanggal_pinjam' => $data['tanggal_pinjam'],
                'tanggal_kembali_rencana' => $data['tanggal_kembali_rencana'],
                'jumlah' => $data['jumlah'],
                'keperluan' => $data['keperluan'],
                'durasi_hari' => $biaya['durasi_hari'],
                'total_biaya' => $biaya['total_biaya'],
                'status' => 'pending',
                'payment_status' => 'pending'
            ]);

            $this->logService->log('create_peminjaman', 'Membuat peminjaman baru ID: ' . $peminjaman->id);

            return $peminjaman;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function prosesPembayaran(Peminjaman $peminjaman)
    {
        try {
            if ($peminjaman->payment_status === 'paid') {
                throw new \Exception('Peminjaman sudah dibayar');
            }

            $peminjaman->update([
                'payment_status' => 'paid',
                'paid_at' => now()
            ]);

            $this->logService->log('bayar_sewa', 'Pembayaran sewa ID: ' . $peminjaman->id . ' - Rp ' . number_format($peminjaman->total_biaya, 0, ',', '.'));

            return $peminjaman->fresh();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
