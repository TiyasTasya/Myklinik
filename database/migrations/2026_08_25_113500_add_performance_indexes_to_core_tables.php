<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function hasIndex(string $table, string $name): bool
    {
        $indexes = collect(DB::select("SHOW INDEX FROM `{$table}`"))->pluck('Key_name')->unique();
        return $indexes->contains($name);
    }

    public function up(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            if (!$this->hasIndex('pasiens', 'pasiens_nama_index')) {
                $table->index('nama');
            }
            if (!$this->hasIndex('pasiens', 'pasiens_nama_panggilan_index')) {
                $table->index('nama_panggilan');
            }
            if (!$this->hasIndex('pasiens', 'pasiens_nomor_kartu_index')) {
                $table->index('nomor_kartu');
            }
            if (!$this->hasIndex('pasiens', 'pasiens_tanggal_lahir_index')) {
                $table->index('tanggal_lahir');
            }
            if (!$this->hasIndex('pasiens', 'pasiens_status_pasien_index')) {
                $table->index('status_pasien');
            }
        });

        Schema::table('pendaftarans', function (Blueprint $table) {
            if (!$this->hasIndex('pendaftarans', 'pendaftarans_tanggal_pendaftaran_index')) {
                $table->index('tanggal_pendaftaran');
            }
            if (!$this->hasIndex('pendaftarans', 'pendaftarans_status_pelayanan_index')) {
                $table->index('status_pelayanan');
            }
            if (!$this->hasIndex('pendaftarans', 'pendaftarans_no_antrian_index')) {
                $table->index('no_antrian');
            }
            if (!$this->hasIndex('pendaftarans', 'pendaftarans_poli_id_tanggal_pendaftaran_index')) {
                $table->index(['poli_id', 'tanggal_pendaftaran']);
            }
            if (!$this->hasIndex('pendaftarans', 'pendaftarans_status_pelayanan_tanggal_pendaftaran_index')) {
                $table->index(['status_pelayanan', 'tanggal_pendaftaran']);
            }
            if (!$this->hasIndex('pendaftarans', 'pendaftarans_pasien_id_tanggal_pendaftaran_index')) {
                $table->index(['pasien_id', 'tanggal_pendaftaran']);
            }
        });

        Schema::table('pegawais', function (Blueprint $table) {
            if (!$this->hasIndex('pegawais', 'pegawais_nip_index')) {
                $table->index('nip');
            }
            if (!$this->hasIndex('pegawais', 'pegawais_nama_lengkap_index')) {
                $table->index('nama_lengkap');
            }
            if (!$this->hasIndex('pegawais', 'pegawais_status_index')) {
                $table->index('status');
            }
        });

        Schema::table('pasien_keluargas', function (Blueprint $table) {
            if (!$this->hasIndex('pasien_keluargas', 'pasien_keluargas_nama_index')) {
                $table->index('nama');
            }
        });

        Schema::table('pasien_kontaks', function (Blueprint $table) {
            if (!$this->hasIndex('pasien_kontaks', 'pasien_kontaks_nomor_kontak_index')) {
                $table->index('nomor_kontak');
            }
        });
    }

    public function down(): void
    {
        // down logic
    }
};

