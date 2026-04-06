<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Services\PeminjamanService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserPeminjamanController extends Controller
{
    protected $peminjamanService;

    public function __construct(PeminjamanService $peminjamanService)
    {
        $this->peminjamanService = $peminjamanService;
    }

    public function index()
    {
        $peminjamans = Peminjaman::with(['alat.kategori', 'pengembalian'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $alats = Alat::with('kategori')
            ->where('stok_tersedia', '>', 0)
            ->get();

        return view('user.peminjaman.create', compact('alats'));
    }

    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Peminjaman Store: Entering method', $request->all());

        $validated = $request->validate([
            'alat_id' => 'required|exists:alat,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'jumlah' => 'required|integer|min:1',
            'keperluan' => 'required|max:500',
        ]);

        \Illuminate\Support\Facades\Log::info('Peminjaman Store: Validation Passed');

        try {
            $validated['user_id'] = auth()->id();
            
            \Illuminate\Support\Facades\Log::info('Peminjaman Store: Calling Service');
            $peminjaman = $this->peminjamanService->createPeminjaman($validated); // Perhatikan method name! Tadi di service createPeminjaman, di controller lama create?
            // Cek controller lama: $this->peminjamanService->create($validated);
            // Cek Service file Step 1093: public function createPeminjaman(array $data)
            // Ternyata nama method beda! Controller panggil create, Service punya createPeminjaman.
            // INI DIA BUG-NYA! Method undefined -> Exception -> Redirect Back with Error -> Tapi Error tidak muncul di layout (sebelum saya fix layout).
            // Tapi kenapa logout? Kalau fatal error mungkin crash.
            
            return redirect()->route('user.peminjaman.index')
                ->with('success', 'Peminjaman berhasil diajukan. Menunggu persetujuan.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Peminjaman Store Error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        // Pastikan user hanya bisa lihat peminjaman sendiri
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        $peminjaman->load(['alat.kategori', 'approver', 'pengembalian.processor']);
        return view('user.peminjaman.show', compact('peminjaman'));
    }
}
