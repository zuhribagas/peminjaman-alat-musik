<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';

    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali_aktual',
        'kondisi_alat',
        'denda',
        'keterangan',
        'processed_by',
        'status_denda',
    ];

    protected $casts = [
        'tanggal_kembali_aktual' => 'date',
        'denda' => 'decimal:2',
    ];

    /**
     * Relationship: Pengembalian belongs to Peminjaman
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    /**
     * Relationship: Pengembalian belongs to User (processor)
     */
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Accessor: Format denda as Rupiah
     */
    public function getDendaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->denda, 0, ',', '.');
    }

    /**
     * Accessor: Get kondisi badge color
     */
    public function getKondisiBadgeAttribute()
    {
        return match($this->kondisi_alat) {
            'baik' => 'success',
            'rusak_ringan' => 'warning',
            'rusak_berat' => 'danger',
            default => 'secondary',
        };
    }
}
