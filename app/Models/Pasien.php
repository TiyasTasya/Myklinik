<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    protected $fillable = [
        'no_rm', 'pasien_tidak_dikenal', 'norm_manual', 'gelar_depan', 'nama', 'gelar_belakang', 'nama_panggilan',
        'tempat_lahir_regency_id', 'tanggal_lahir', 'jenis_kelamin',
        'agama_detail_id', 'status_perkawinan_detail_id', 'pendidikan_detail_id', 'pekerjaan_detail_id',
        'golongan_darah_detail_id', 'suku_bangsa_detail_id',
        'country_id', 'status_pasien',
        'unit_eksternal_id', 'sub_unit_eksternal_id',
        'alamat', 'rt', 'rw', 'kode_pos', 'province_id', 'regency_id', 'district_id', 'village_id',
        'sama_dengan_alamat_sekarang', 'jenis_kartu_detail_id', 'nomor_kartu',
        'alamat_kartu', 'rt_kartu', 'rw_kartu', 'kode_pos_kartu',
        'province_id_kartu', 'regency_id_kartu', 'district_id_kartu', 'village_id_kartu',
    ];

    protected $casts = [
        'pasien_tidak_dikenal' => 'boolean',
        'sama_dengan_alamat_sekarang' => 'boolean',
        'tanggal_lahir' => 'date',
    ];

    public function kontaks(): HasMany
    {
        return $this->hasMany(PasienKontak::class);
    }

    public function keluargas(): HasMany
    {
        return $this->hasMany(PasienKeluarga::class);
    }

    public function ibu(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PasienKeluarga::class)
            ->whereHas('statusKeluarga', fn ($query) => $query->where('deskripsi', 'Ibu'));
    }

    public function agama(): BelongsTo { return $this->belongsTo(ReferensiDetail::class, 'agama_detail_id'); }
    public function statusPerkawinan(): BelongsTo { return $this->belongsTo(ReferensiDetail::class, 'status_perkawinan_detail_id'); }
    public function pendidikan(): BelongsTo { return $this->belongsTo(ReferensiDetail::class, 'pendidikan_detail_id'); }
    public function pekerjaan(): BelongsTo { return $this->belongsTo(ReferensiDetail::class, 'pekerjaan_detail_id'); }
    public function golonganDarah(): BelongsTo { return $this->belongsTo(ReferensiDetail::class, 'golongan_darah_detail_id'); }
    public function sukuBangsa(): BelongsTo { return $this->belongsTo(ReferensiDetail::class, 'suku_bangsa_detail_id'); }
    public function jenisKartu(): BelongsTo { return $this->belongsTo(ReferensiDetail::class, 'jenis_kartu_detail_id'); }

    // Relasi ini WAJIB ada untuk Select::make('country_id')->relationship('country', 'name')
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function tempatLahir(): BelongsTo { return $this->belongsTo(Regency::class, 'tempat_lahir_regency_id'); }
    public function province(): BelongsTo { return $this->belongsTo(Province::class); }
    public function regency(): BelongsTo { return $this->belongsTo(Regency::class); }
    public function district(): BelongsTo { return $this->belongsTo(District::class); }
    public function village(): BelongsTo { return $this->belongsTo(Village::class); }

    public function unitEksternal(): BelongsTo { return $this->belongsTo(UnitEksternal::class, 'unit_eksternal_id'); }
    public function subUnitEksternal(): BelongsTo { return $this->belongsTo(UnitEksternal::class, 'sub_unit_eksternal_id'); }
}
