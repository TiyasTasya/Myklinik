<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'tempat_tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'profesi',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kontaks(): HasMany
    {
        return $this->hasMany(KontakPegawai::class);
    }

    public function agama(): BelongsTo
    {
        return $this->belongsTo(ReferensiDetail::class, 'agama_detail_id');
    }
    public function jenisSpesialis(): BelongsTo
    {
        return $this->belongsTo(ReferensiDetail::class, 'jenis_spesialis_detail_id');
    }
    public function jenisKartu(): BelongsTo
    {
        return $this->belongsTo(ReferensiDetail::class, 'jenis_kartu_detail_id');
    }
    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }
    public function tempatLahir(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'tempat_lahir_regency_id');
    }
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
