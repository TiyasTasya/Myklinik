<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasienKontak extends Model
{
    protected $fillable = ['pasien_id', 'jenis_kontak_detail_id', 'nomor_kontak'];

    public function pasien(): BelongsTo { return $this->belongsTo(Pasien::class); }
    public function jenisKontak(): BelongsTo { return $this->belongsTo(ReferensiDetail::class, 'jenis_kontak_detail_id'); }
}
