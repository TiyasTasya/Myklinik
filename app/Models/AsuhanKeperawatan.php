<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsuhanKeperawatan extends Model
{
    use HasFactory;

    protected $table = 'asuhan_keperawatans';

    protected $fillable = [
        'pendaftaran_id',
        'pasien_id',
        'pegawai_id',
        'data_mayor_subjektif',
        'data_mayor_objektif',
        'data_minor_subjektif',
        'data_minor_objektif',
        'faktor_resiko',
        'diagnosis_keperawatan',
        'penyebab',
        'intervensi',
        'kriteria_hasil',
        'observasi',
        'terapeutik',
        'edukasi',
        'kolaborasi',
        'is_verified',
        'waktu_input',
    ];

    protected $casts = [
        'waktu_input' => 'datetime',
        'is_verified' => 'boolean',
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

