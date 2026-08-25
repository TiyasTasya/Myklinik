<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemeriksaanFisik extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_fisiks';

    protected $fillable = [
        'pendaftaran_id',
        'pasien_id',
        'pegawai_id',
        'keadaan_umum',
        'tingkat_kesadaran',
        'gcs_eye',
        'gcs_motorik',
        'gcs_verbal',
        'gcs_total',
        'sistolik',
        'diastolik',
        'frekuensi_nadi',
        'frekuensi_nafas',
        'suhu',
        'saturasi_o2',
        'alat_bantu_nafas',
        'skor_ewss',
        'kategori_ewss',
        'waktu_pemeriksaan',
        'catatan_tambahan',
    ];

    protected $casts = [
        'waktu_pemeriksaan' => 'datetime',
        'alat_bantu_nafas'  => 'boolean',
        'suhu'              => 'decimal:1',
    ];

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}

