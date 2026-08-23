<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferensiDetail extends Model
{
    protected $fillable = ['referensi_id', 'deskripsi', 'urutan', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function referensi(): BelongsTo
    {
        return $this->belongsTo(Referensi::class);
    }
}
