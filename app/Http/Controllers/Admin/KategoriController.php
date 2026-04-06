<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Services\LogService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('alat')->paginate(10);
        return view('admin.pages.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.pages.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|max:100',
            'deskripsi' => 'nullable',
        ]);

        $kategori = Kategori::create($validated);
        
        LogService::log('create_kategori', "Menambahkan kategori: {$kategori->nama_kategori}");

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.pages.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|max:100',
            'deskripsi' => 'nullable',
        ]);

        $kategori->update($validated);
        
        LogService::log('update_kategori', "Mengupdate kategori: {$kategori->nama_kategori}");

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(Kategori $kategori)
    {
        try {
            // Optional: Block delete if has related alat (manual check specific)
            if ($kategori->alat()->exists()) {
                 return back()->with('error', 'Gagal! Kategori ini masih memiliki alat yang terdaftar. Hapus alat terlebih dahulu.');
            }

            $nama = $kategori->nama_kategori;
            $kategori->delete();
            
            LogService::log('delete_kategori', "Menghapus kategori: {$nama}");
    
            return redirect()->route('admin.kategori.index')
                ->with('success', 'Kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                 return back()->with('error', 'Gagal! Kategori sedang digunakan oleh data lain.');
            }
            return back()->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }
}
