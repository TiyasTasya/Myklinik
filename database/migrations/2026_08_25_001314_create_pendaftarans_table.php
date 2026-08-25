<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran', 50)->unique();
            $table->string('no_antrian', 20)->nullable();
            $table->dateTime('tanggal_pendaftaran')->useCurrent();
            
            // Relasi Utama
            $table->foreignId('pasien_id')->constrained('pasiens')->cascadeOnDelete();
            $table->foreignId('poli_id')->constrained('polis')->cascadeOnDelete();
            $table->foreignId('dokter_id')->nullable()->constrained('pegawais')->nullOnDelete();
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();

            // Pelayanan & Integrasi
            $table->string('jenis_pelayanan', 50)->default('Pelayanan Rawat Jalan');
            $table->boolean('general_consent')->default(true);
            $table->boolean('consent_satusehat')->default(true);
            $table->boolean('resiko_jatuh')->default(false);

            // Kategori Kunjungan & Penjamin
            $table->enum('jenis_kunjungan', ['Baru', 'Lama'])->default('Lama');
            $table->string('cara_masuk', 50)->default('Datang Sendiri');
            $table->string('penjamin', 50)->default('Tanpa Asuransi / Umum');
            $table->string('no_asuransi', 100)->nullable();
            $table->string('no_sep', 100)->nullable();
            $table->string('kelas_rawat', 50)->nullable();

            // Rujukan (Bila ada)
            $table->boolean('is_rujukan')->default(false);
            $table->string('faskes_perujuk')->nullable();
            $table->string('no_rujukan')->nullable();
            $table->date('tgl_rujukan')->nullable();
            $table->string('dokter_perujuk')->nullable();
            $table->string('diagnosis_rujukan')->nullable();

            // Kasus Kecelakaan (Bila ada)
            $table->boolean('is_kecelakaan')->default(false);
            $table->string('jenis_kecelakaan')->nullable();
            $table->string('no_laporan_polisi')->nullable();
            $table->date('tgl_kejadian_kecelakaan')->nullable();
            $table->string('penjamin_kecelakaan')->nullable();
            $table->string('lokasi_kecelakaan')->nullable();

            // Penanggung Jawab Pasien
            $table->string('pj_nama')->nullable();
            $table->string('pj_hubungan', 50)->nullable();
            $table->date('pj_tgl_lahir')->nullable();
            $table->string('pj_pekerjaan')->nullable();
            $table->string('pj_jenis_kartu')->nullable();
            $table->string('pj_nomor_kartu')->nullable();
            $table->string('pj_no_telepon', 30)->nullable();
            $table->text('pj_alamat')->nullable();

            // Pengantar Pasien
            $table->string('pengantar_nama')->nullable();
            $table->string('pengantar_hubungan', 50)->nullable();
            $table->string('pengantar_no_telepon', 30)->nullable();
            $table->text('pengantar_alamat')->nullable();

            // Status Pelayanan & Kasir
            $table->enum('status_pelayanan', ['Menunggu', 'Sedang Diperiksa', 'Selesai', 'Batal'])->default('Menunggu');
            $table->decimal('biaya_pendaftaran', 12, 2)->default(0);
            $table->enum('status_pembayaran', ['Belum Lunas', 'Lunas', 'Gratis'])->default('Belum Lunas');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
