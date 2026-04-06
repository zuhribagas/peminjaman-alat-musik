<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // ✅ sudah benar di dalam class
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is petugas
     */
    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    /**
     * Check if user is peminjam
     */
    public function isPeminjam()
    {
        return $this->role === 'user';
    }

    /**
     * Relationship: User has many Peminjaman
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'user_id');
    }

    /**
     * Relationship: User has many LogAktivitas
     */
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'user_id');
    }
}
