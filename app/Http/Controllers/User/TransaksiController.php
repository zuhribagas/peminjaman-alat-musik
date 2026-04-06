<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Peminjaman::with(['alat.kategori'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalTransaksi = Peminjaman::where('user_id', auth()->id())->count();
        $totalBelanja = Peminjaman::where('user_id', auth()->id())->sum('total_biaya');
        $transaksiAktif = Peminjaman::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->count();

        return view('user.transaksi.index', compact('transaksi', 'totalTransaksi', 'totalBelanja', 'transaksiAktif'));
    }
}
