<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CpptRecord extends Model
{
    protected $table = 'cppt_records';

    protected $fillable = [
        'pendaftaran_id',
        'pasien_id',
        'pegawai_id',
        'nama_ppa',
        'profesi',
        'tanggal_waktu',
        'metode',
        'subjektif',
        'objektif',
        'assessment',
        'planning',
        'instruksi',
        'is_sbar',
        'is_tbak',
        'is_verified',
        'verified_by_pegawai_id',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
        'verified_at' => 'datetime',
        'is_sbar' => 'boolean',
        'is_tbak' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'verified_by_pegawai_id');
    }
}

