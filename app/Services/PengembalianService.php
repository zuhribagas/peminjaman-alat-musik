<?php

namespace App\Services;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\LogService;

class PengembalianService
{
    protected $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    private function hitungDenda(Peminjaman $peminjaman, $tanggalKembaliAktual)
    {
        $tanggalKembaliRencana = Carbon::parse($peminjaman->tanggal_kembali_rencana);
        $tanggalAktual = Carbon::parse($tanggalKembaliAktual);
        
        // Logic: Rencana (Target) - Aktual (Now). 
        // JIka Rencana > Aktual (misal tgl 30 > 29) -> diffInDays(false) returns negative?
        // Carbon: $a->diffInDays($b, false) = $b - $a.
        // Kita mau: Aktual - Rencana.
        // Jika Aktual (31) - Rencana (30) = +1 (Telat).
        // Jika Aktual (29) - Rencana (30) = -1 (Early).
        
        $keterlambatan = $tanggalKembaliRencana->diffInDays($tanggalAktual, false);
        $dendaPerHari = 5000; // Sesuai request user Rp 5.000
        
        return $keterlambatan > 0 ? $keterlambatan * $dendaPerHari : 0;
    }

    public function createPengembalian(array $data)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($data['peminjaman_id']);

            if ($peminjaman->status !== 'approved') {
                throw new \Exception('Peminjaman belum disetujui atau sudah dikembalikan');
            }

            $denda = $this->hitungDenda($peminjaman, $data['tanggal_kembali_aktual']);

            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tanggal_kembali_aktual' => $data['tanggal_kembali_aktual'],
                'kondisi_alat' => $data['kondisi_alat'],
                'denda' => $denda,
                'keterangan' => $data['keterangan'] ?? null,
                'processed_by' => auth()->id()
            ]);

            $peminjaman->update([
                'status' => 'returned'
            ]);

            $peminjaman->alat->update([
                'stok_tersedia' => $peminjaman->alat->stok_tersedia + $peminjaman->jumlah
            ]);

            $this->logService->log('create_pengembalian', 'Memproses pengembalian ID: ' . $pengembalian->id);

            return $pengembalian;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
