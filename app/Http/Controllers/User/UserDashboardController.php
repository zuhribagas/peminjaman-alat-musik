<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_peminjaman' => Peminjaman::where('user_id', $user->id)->count(),
            'pending' => Peminjaman::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved' => Peminjaman::where('user_id', $user->id)->where('status', 'approved')->count(),
            'returned' => Peminjaman::where('user_id', $user->id)->where('status', 'returned')->count(),
        ];

        $recent_peminjaman = Peminjaman::with(['alat.kategori', 'pengembalian'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $alat_tersedia = Alat::with('kategori')
            ->where('stok_tersedia', '>', 0)
            ->limit(6)
            ->get();

        return view('user.dashboard', compact('stats', 'recent_peminjaman', 'alat_tersedia'));
    }
}
