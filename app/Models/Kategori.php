<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * Relationship: Kategori has many Alat
     */
    public function alat()
    {
        return $this->hasMany(Alat::class, 'kategori_id');
    }
}
