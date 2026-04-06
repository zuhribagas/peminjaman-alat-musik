<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    protected $peminjamanService;

    public function __construct(PeminjamanService $peminjamanService)
    {
        $this->peminjamanService = $peminjamanService;
    }

    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat', 'approver']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.pages.peminjaman.index', compact('peminjamans'));
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'alat.kategori', 'approver', 'pengembalian.processor']);
        return view('admin.pages.peminjaman.show', compact('peminjaman'));
    }

    public function approve(Peminjaman $peminjaman)
    {
        try {
            $this->peminjamanService->approvePeminjaman($peminjaman);
            return redirect()->back()->with('success', 'Peminjaman berhasil disetujui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        try {
            $this->peminjamanService->rejectPeminjaman($peminjaman, $request->alasan); // Note: rejectPeminjaman signature check needed
            return redirect()->back()->with('success', 'Peminjaman berhasil ditolak');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya peminjaman pending yang bisa dihapus');
        }

        $peminjaman->delete();
        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }
}
