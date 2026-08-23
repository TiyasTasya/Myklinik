<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'satuan_id',
        'merk',
        'penyedia_id',
        'generik',
        'jenis_penggunaan',
        'stok_minimum',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'stok_minimum' => 'integer',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function satuan(): BelongsTo
    {
        return $this->belongsTo(Satuan::class);
    }

    public function penyedia(): BelongsTo
    {
        return $this->belongsTo(Penyedia::class);
    }
}
