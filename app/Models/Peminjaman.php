<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'alat_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'jumlah',
        'keperluan',
        'status',
        'approved_by',
        'approved_at',
        'durasi_hari',
        'total_biaya',
        'payment_status',
        'paid_at'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Relationship: Peminjaman belongs to User (peminjam)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: Peminjaman belongs to Alat
     */
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    /**
     * Relationship: Peminjaman belongs to User (approver)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relationship: Peminjaman has one Pengembalian
     */
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }

    /**
     * Accessor: Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'returned' => 'info',
            default => 'secondary',
        };
    }

    /**
     * Accessor: Get status text
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'returned' => 'Sudah Dikembalikan',
            default => 'Unknown',
        };
    }

    /**
     * Scope: Peminjaman with status pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Peminjaman with status approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Peminjaman with status rejected
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope: Peminjaman with status returned
     */
    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }

    /**
     * Scope: Peminjaman by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if peminjaman is overdue
     */
    public function isOverdue()
    {
        if ($this->status !== 'approved') {
            return false;
        }
        
        return Carbon::now()->gt($this->tanggal_kembali_rencana);
    }

    /**
     * Get days overdue
     */
    public function getDaysOverdue()
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        
        return Carbon::now()->diffInDays($this->tanggal_kembali_rencana);
    }
}
