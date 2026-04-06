<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alat';

    protected $fillable = [
        'kategori_id',
        'kode_alat',
        'nama_alat',
        'deskripsi',
        'stok_total',
        'stok_tersedia',
        'kondisi',
        'foto',
        'harga_sewa_per_hari'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'alat_id');
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('images/no-image.png');
    }

    public function scopeTersedia($query)
    {
        return $query->where('stok_tersedia', '>', 0);
    }

    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_id', $kategoriId);
    }
    
    public function getHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga_sewa_per_hari, 0, ',', '.');
    }
}
