<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penyedia extends Model
{
    protected $fillable = [
        'nama',
        'alamat',
        'no_telepon',
        'fax',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}
