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
        Schema::create('pemeriksaan_fisiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->cascadeOnDelete();
            $table->foreignId('pasien_id')->constrained('pasiens')->cascadeOnDelete();
            $table->foreignId('pegawai_id')->nullable()->constrained('pegawais')->nullOnDelete();

            $table->string('keadaan_umum')->nullable()->default('Baik');
            $table->string('tingkat_kesadaran')->nullable()->default('Sadar Baik / Alert');
            $table->integer('gcs_eye')->nullable()->default(4);
            $table->integer('gcs_motorik')->nullable()->default(6);
            $table->integer('gcs_verbal')->nullable()->default(5);
            $table->integer('gcs_total')->nullable()->default(15);

            $table->integer('sistolik')->nullable()->default(120);
            $table->integer('diastolik')->nullable()->default(80);
            $table->integer('frekuensi_nadi')->nullable()->default(80);
            $table->integer('frekuensi_nafas')->nullable()->default(20);
            $table->decimal('suhu', 4, 1)->nullable()->default(36.5);
            $table->integer('saturasi_o2')->nullable()->default(98);
            $table->boolean('alat_bantu_nafas')->default(false);

            $table->integer('skor_ewss')->default(0);
            $table->string('kategori_ewss')->default('Normal');
            $table->dateTime('waktu_pemeriksaan')->useCurrent();
            $table->text('catatan_tambahan')->nullable();

            $table->timestamps();
        });

        Schema::create('asuhan_keperawatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->cascadeOnDelete();
            $table->foreignId('pasien_id')->constrained('pasiens')->cascadeOnDelete();
            $table->foreignId('pegawai_id')->nullable()->constrained('pegawais')->nullOnDelete();

            $table->text('data_mayor_subjektif')->nullable();
            $table->text('data_mayor_objektif')->nullable();
            $table->text('data_minor_subjektif')->nullable();
            $table->text('data_minor_objektif')->nullable();
            $table->text('faktor_resiko')->nullable();
            $table->string('diagnosis_keperawatan')->nullable();
            $table->string('penyebab')->nullable();
            $table->text('intervensi')->nullable();
            $table->text('kriteria_hasil')->nullable();
            $table->text('observasi')->nullable();
            $table->text('terapeutik')->nullable();
            $table->text('edukasi')->nullable();
            $table->text('kolaborasi')->nullable();

            $table->boolean('is_verified')->default(false);
            $table->dateTime('waktu_input')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asuhan_keperawatans');
        Schema::dropIfExists('pemeriksaan_fisiks');
    }
};
