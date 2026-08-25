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
            $table->string('province_id', 20)->nullable();
            $table->string('regency_id', 20)->nullable();
            $table->string('district_id', 20)->nullable();
            $table->string('village_id', 20)->nullable();
            $table->foreign('province_id')->references('code')->on('indonesia_regions')->nullOnDelete();
            $table->foreign('regency_id')->references('code')->on('indonesia_regions')->nullOnDelete();
            $table->foreign('district_id')->references('code')->on('indonesia_regions')->nullOnDelete();
            $table->foreign('village_id')->references('code')->on('indonesia_regions')->nullOnDelete();

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
