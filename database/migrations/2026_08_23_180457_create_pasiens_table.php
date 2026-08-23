<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();

            // Identitas
            $table->string('no_rm')->unique()->nullable();
            $table->boolean('pasien_tidak_dikenal')->default(false);
            $table->string('norm_manual')->nullable();
            $table->string('gelar_depan')->nullable();
            $table->string('nama');
            $table->string('gelar_belakang')->nullable();
            $table->string('nama_panggilan')->nullable();

            $table->char('tempat_lahir_regency_id', 4)->nullable();
            $table->foreign('tempat_lahir_regency_id')->references('id')->on('regencies')->nullOnDelete();

            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);

            // Referensi (FK ke referensi_details)
            $table->foreignId('agama_detail_id')->nullable()->constrained('referensi_details')->nullOnDelete();
            $table->foreignId('status_perkawinan_detail_id')->nullable()->constrained('referensi_details')->nullOnDelete();
            $table->foreignId('pendidikan_detail_id')->nullable()->constrained('referensi_details')->nullOnDelete();
            $table->foreignId('pekerjaan_detail_id')->nullable()->constrained('referensi_details')->nullOnDelete();
            $table->foreignId('golongan_darah_detail_id')->nullable()->constrained('referensi_details')->nullOnDelete();
            $table->foreignId('suku_bangsa_detail_id')->nullable()->constrained('referensi_details')->nullOnDelete();

            // Kewarganegaraan -> relasi ke tabel countries
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();

            $table->enum('status_pasien', ['Hidup', 'Meninggal'])->default('Hidup');

            // Asal Instansi
            $table->foreignId('unit_eksternal_id')->nullable()->constrained('unit_eksternals')->nullOnDelete();
            $table->foreignId('sub_unit_eksternal_id')->nullable()->constrained('unit_eksternals')->nullOnDelete();

            // Alamat Sekarang
            $table->text('alamat')->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->char('province_id', 2)->nullable();
            $table->char('regency_id', 4)->nullable();
            $table->char('district_id', 7)->nullable();
            $table->char('village_id', 10)->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->nullOnDelete();
            $table->foreign('regency_id')->references('id')->on('regencies')->nullOnDelete();
            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();
            $table->foreign('village_id')->references('id')->on('villages')->nullOnDelete();

            // Kartu Identitas
            $table->boolean('sama_dengan_alamat_sekarang')->default(false);
            $table->foreignId('jenis_kartu_detail_id')->nullable()->constrained('referensi_details')->nullOnDelete();
            $table->string('nomor_kartu')->nullable();
            $table->text('alamat_kartu')->nullable();
            $table->string('rt_kartu', 5)->nullable();
            $table->string('rw_kartu', 5)->nullable();
            $table->string('kode_pos_kartu', 10)->nullable();
            $table->char('province_id_kartu', 2)->nullable();
            $table->char('regency_id_kartu', 4)->nullable();
            $table->char('district_id_kartu', 7)->nullable();
            $table->char('village_id_kartu', 10)->nullable();
            $table->foreign('province_id_kartu')->references('id')->on('provinces')->nullOnDelete();
            $table->foreign('regency_id_kartu')->references('id')->on('regencies')->nullOnDelete();
            $table->foreign('district_id_kartu')->references('id')->on('districts')->nullOnDelete();
            $table->foreign('village_id_kartu')->references('id')->on('villages')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
