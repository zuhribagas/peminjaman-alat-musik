<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat.kategori']);
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        $transaksi = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $users = User::where('role', 'user')->get();
        $totalTransaksi = Peminjaman::count();
        $totalPendapatan = Peminjaman::where('payment_status', 'paid')->sum('total_biaya');
        $menungguPembayaran = Peminjaman::where('payment_status', 'pending')->count();
        
        return view('admin.pages.transaksi.index', compact('transaksi', 'users', 'totalTransaksi', 'totalPendapatan', 'menungguPembayaran'));
    }
}
