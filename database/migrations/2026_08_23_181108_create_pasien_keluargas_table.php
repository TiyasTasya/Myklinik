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
        Schema::create('pasien_keluargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->cascadeOnDelete();
            $table->foreignId('status_keluarga_detail_id')->nullable()->constrained('referensi_details')->nullOnDelete();

            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->foreignId('pendidikan_detail_id')->nullable()->constrained('referensi_details')->nullOnDelete();
            $table->foreignId('pekerjaan_detail_id')->nullable()->constrained('referensi_details')->nullOnDelete();
            $table->text('alamat')->nullable();

            $table->foreignId('jenis_kartu_detail_id')->nullable()->constrained('referensi_details')->nullOnDelete();
            $table->string('nomor_kartu')->nullable();
            $table->text('alamat_kartu')->nullable();
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

            $table->string('telepon_seluler')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien_keluargas');
    }
};
