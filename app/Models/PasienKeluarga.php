<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasienKeluarga extends Model
{
    protected $fillable = [
        'pasien_id', 'status_keluarga_detail_id', 'nama', 'jenis_kelamin', 'tanggal_lahir',
        'pendidikan_detail_id', 'pekerjaan_detail_id', 'alamat',
        'jenis_kartu_detail_id', 'nomor_kartu', 'alamat_kartu',
        'rt', 'rw', 'kode_pos', 'province_id', 'regency_id', 'district_id', 'village_id',
        'telepon_seluler',
    ];

    protected $casts = ['tanggal_lahir' => 'date'];

    public function pasien(): BelongsTo { return $this->belongsTo(Pasien::class); }
    public function statusKeluarga(): BelongsTo { return $this->belongsTo(ReferensiDetail::class, 'status_keluarga_detail_id'); }
}
