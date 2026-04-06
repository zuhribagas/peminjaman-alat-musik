<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Services\PengembalianService;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    protected $pengembalianService;

    public function __construct(PengembalianService $pengembalianService)
    {
        $this->pengembalianService = $pengembalianService;
    }

    /**
     * Display list of pengembalian
     */
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.alat', 'processor'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.pages.pengembalian.index', compact('pengembalians'));
    }

    /**
     * Show form to process pengembalian
     */
    public function create(Peminjaman $peminjaman)
    {
        // Check if peminjaman is approved and not yet returned
        if ($peminjaman->status !== 'approved') {
            $routePrefix = auth()->user()->role === 'petugas' ? 'petugas' : 'admin';
            return redirect()->route($routePrefix . '.peminjaman.index')
                ->with('error', 'Peminjaman belum diapprove atau sudah dikembalikan');
        }

        return view('admin.pages.pengembalian.create', compact('peminjaman'));
    }

    /**
     * Store pengembalian
     */
    public function store(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'tanggal_kembali_aktual' => 'required|date',
            'kondisi_alat' => 'required|in:baik,rusak_ringan,rusak_berat',
            'keterangan' => 'nullable|max:500',
        ]);

        try {
            $validated['peminjaman_id'] = $peminjaman->id;
            
            $pengembalian = $this->pengembalianService->createPengembalian($validated);

            $message = "Pengembalian berhasil diproses.";
            if ($pengembalian->denda > 0) {
                $message .= " Denda: " . $pengembalian->denda_formatted;
            }

            $routePrefix = auth()->user()->role === 'petugas' ? 'petugas' : 'admin';
            return redirect()->route($routePrefix . '.pengembalian.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Mark all payments (rental + denda) as paid
     */
    public function markPaid(Pengembalian $pengembalian)
    {
        // 1. Lunasi Denda
        $pengembalian->update([
            'status_denda' => 'paid'
        ]);

        // 2. Lunasi Biaya Sewa (jika belum)
        $pengembalian->peminjaman->update([
            'payment_status' => 'paid',
            'paid_at' => now()
        ]);

        return redirect()->back()->with('success', 'Pembayaran (Sewa + Denda) berhasil ditandai LUNAS.');
    }

    /**
     * Show pengembalian detail
     */
    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load(['peminjaman.user', 'peminjaman.alat.kategori', 'processor']);
        return view('admin.pages.pengembalian.show', compact('pengembalian'));
    }
}
