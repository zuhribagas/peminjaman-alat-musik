<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserPeminjamanController;
use App\Http\Controllers\User\TransaksiController as UserTransaksiController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    
    return view('welcome');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('kategori', KategoriController::class)->except(['show']);
    
    Route::resource('alat', AlatController::class);
    
    Route::resource('users', UserController::class);
    
    Route::resource('peminjaman', PeminjamanController::class)->only(['index', 'show', 'destroy']);
    Route::post('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    
    
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create/{peminjaman}', [PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian/{peminjaman}', [PengembalianController::class, 'store'])->name('pengembalian.store');
    Route::post('/pengembalian/{pengembalian}/mark-paid', [PengembalianController::class, 'markPaid'])->name('pengembalian.markPaid');
    Route::get('/pengembalian/{pengembalian}', [PengembalianController::class, 'show'])->name('pengembalian.show');
    
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
});


Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', function () {
        return view('petugas.index');
    })->name('dashboard');
    
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::post('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create/{peminjaman}', [PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian/{peminjaman}', [PengembalianController::class, 'store'])->name('pengembalian.store');
    Route::post('/pengembalian/{pengembalian}/mark-paid', [PengembalianController::class, 'markPaid'])->name('pengembalian.markPaid');
    Route::get('/pengembalian/{pengembalian}', [PengembalianController::class, 'show'])->name('pengembalian.show');
    
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    
    Route::resource('alat', AlatController::class);
    Route::resource('kategori', KategoriController::class)->except(['show']);
});


Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('peminjaman', UserPeminjamanController::class)->only(['index', 'create', 'store', 'show']);
    
    Route::get('/transaksi', [UserTransaksiController::class, 'index'])->name('transaksi');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
