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
        Schema::create('cppt_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->cascadeOnDelete();
            $table->foreignId('pasien_id')->constrained('pasiens')->cascadeOnDelete();
            $table->foreignId('pegawai_id')->nullable()->constrained('pegawais')->nullOnDelete();
            $table->string('nama_ppa')->nullable();
            $table->string('profesi')->default('Dokter');
            $table->dateTime('tanggal_waktu')->useCurrent();
            $table->string('metode')->default('SOAP');
            $table->longText('subjektif')->nullable();
            $table->longText('objektif')->nullable();
            $table->longText('assessment')->nullable();
            $table->longText('planning')->nullable();
            $table->text('instruksi')->nullable();
            $table->boolean('is_sbar')->default(false);
            $table->boolean('is_tbak')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->foreignId('verified_by_pegawai_id')->nullable()->constrained('pegawais')->nullOnDelete();
            $table->dateTime('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cppt_records');
    }
};
