<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_alat' => Alat::count(),
            'total_kategori' => Kategori::count(),
            'peminjaman_pending' => Peminjaman::where('status', 'pending')->count(),
            'peminjaman_approved' => Peminjaman::where('status', 'approved')->count(),
            'peminjaman_returned' => Peminjaman::where('status', 'returned')->count(),
        ];

        $recent_peminjaman = Peminjaman::with(['user', 'alat'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.index', compact('stats', 'recent_peminjaman'));
    }
}
