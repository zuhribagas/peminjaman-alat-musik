<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori')->paginate(15);
        return view('admin.pages.alat.index', compact('alats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.pages.alat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'kode_alat' => 'required|unique:alat,kode_alat|max:50',
            'nama_alat' => 'required|max:255',
            'deskripsi' => 'nullable',
            'stok_total' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'foto' => 'nullable|image|max:2048',
        ]);

        $validated['stok_tersedia'] = $validated['stok_total'];

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('alat', 'public');
        }

        $alat = Alat::create($validated);
        
        LogService::log('create_alat', "Menambahkan alat: {$alat->nama_alat} ({$alat->kode_alat})");

        return redirect()->route('admin.alat.index')
            ->with('success', 'Alat berhasil ditambahkan');
    }

    /**
     * Display the specified alat.
     */
    public function show(Alat $alat)
    {
        return view('admin.pages.alat.show', compact('alat'));
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();
        return view('admin.pages.alat.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'kode_alat' => 'required|max:50|unique:alat,kode_alat,' . $alat->id,
            'nama_alat' => 'required|max:255',
            'deskripsi' => 'nullable',
            'stok_total' => 'required|integer|min:0',
            'stok_tersedia' => 'required|integer|min:0|lte:stok_total',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($alat->foto) {
                Storage::disk('public')->delete($alat->foto);
            }
            $validated['foto'] = $request->file('foto')->store('alat', 'public');
        }

        $alat->update($validated);
        
        LogService::log('update_alat', "Mengupdate alat: {$alat->nama_alat} ({$alat->kode_alat})");

        return redirect()->route('admin.alat.index')
            ->with('success', 'Alat berhasil diupdate');
    }

    public function destroy(Alat $alat)
    {
        try {
            if ($alat->foto) {
                Storage::disk('public')->delete($alat->foto);
            }
    
            $nama = $alat->nama_alat;
            $alat->delete();
            
            LogService::log('delete_alat', "Menghapus alat: {$nama}");
    
            return redirect()->route('admin.alat.index')
                ->with('success', 'Alat berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for integrity constraint violation (SQLSTATE 23000)
            if ($e->getCode() == 23000) {
                return back()->with('error', 'Gagal menghapus! Alat ini sedang digunakan dalam transaksi peminjaman.');
            }
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan tak terduga.');
        }
    }
}
