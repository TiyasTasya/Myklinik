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
        Schema::table('pegawais', function (Blueprint $table) {
            // Identitas tambahan
            $table->string('gelar_depan')->nullable()->after('nip');
            $table->string('gelar_belakang')->nullable()->after('nama_lengkap');

            $table->string('tempat_lahir_regency_id', 20)->nullable()->after('tempat_tanggal_lahir');
            $table->foreign('tempat_lahir_regency_id')->references('code')->on('indonesia_regions')->nullOnDelete();
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir_regency_id');

            $table->foreignId('agama_detail_id')->nullable()->after('jenis_kelamin')->constrained('referensi_details')->nullOnDelete();

            // Profesi khusus (kondisional kalau profesi = Dokter)
            $table->foreignId('jenis_spesialis_detail_id')->nullable()->after('profesi')->constrained('referensi_details')->nullOnDelete();
            $table->foreignId('poli_id')->nullable()->after('jenis_spesialis_detail_id')->constrained('polis')->nullOnDelete();
            $table->string('no_str')->nullable()->after('poli_id');
            $table->date('str_berlaku_sampai')->nullable()->after('no_str');
            $table->string('no_sip')->nullable()->after('str_berlaku_sampai');
            $table->date('sip_berlaku_sampai')->nullable()->after('no_sip');

            // Kartu Identitas
            $table->foreignId('jenis_kartu_detail_id')->nullable()->after('sip_berlaku_sampai')->constrained('referensi_details')->nullOnDelete();
            $table->string('nomor_kartu')->nullable()->after('jenis_kartu_detail_id');
            $table->text('alamat_kartu')->nullable()->after('nomor_kartu');
            $table->string('rt_kartu', 5)->nullable()->after('alamat_kartu');
            $table->string('rw_kartu', 5)->nullable()->after('rt_kartu');
            $table->string('kode_pos_kartu', 10)->nullable()->after('rw_kartu');
            $table->string('province_id_kartu', 20)->nullable()->after('kode_pos_kartu');
            $table->string('regency_id_kartu', 20)->nullable()->after('province_id_kartu');
            $table->string('district_id_kartu', 20)->nullable()->after('regency_id_kartu');
            $table->string('village_id_kartu', 20)->nullable()->after('district_id_kartu');
            $table->foreign('province_id_kartu')->references('code')->on('indonesia_regions')->nullOnDelete();
            $table->foreign('regency_id_kartu')->references('code')->on('indonesia_regions')->nullOnDelete();
            $table->foreign('district_id_kartu')->references('code')->on('indonesia_regions')->nullOnDelete();
            $table->foreign('village_id_kartu')->references('code')->on('indonesia_regions')->nullOnDelete();

            // Alamat berjenjang
            $table->string('rt', 5)->nullable()->after('alamat');
            $table->string('rw', 5)->nullable()->after('rt');
            $table->string('kode_pos', 10)->nullable()->after('rw');
            $table->string('province_id', 20)->nullable()->after('kode_pos');
            $table->string('regency_id', 20)->nullable()->after('province_id');
            $table->string('district_id', 20)->nullable()->after('regency_id');
            $table->string('village_id', 20)->nullable()->after('district_id');
            $table->foreign('province_id')->references('code')->on('indonesia_regions')->nullOnDelete();
            $table->foreign('regency_id')->references('code')->on('indonesia_regions')->nullOnDelete();
            $table->foreign('district_id')->references('code')->on('indonesia_regions')->nullOnDelete();
            $table->foreign('village_id')->references('code')->on('indonesia_regions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tempat_lahir_regency_id');
            $table->dropConstrainedForeignId('agama_detail_id');
            $table->dropConstrainedForeignId('jenis_spesialis_detail_id');
            $table->dropConstrainedForeignId('poli_id');
            $table->dropConstrainedForeignId('jenis_kartu_detail_id');
            $table->dropForeign(['province_id_kartu']);
            $table->dropForeign(['regency_id_kartu']);
            $table->dropForeign(['district_id_kartu']);
            $table->dropForeign(['village_id_kartu']);
            $table->dropForeign(['province_id']);
            $table->dropForeign(['regency_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['village_id']);

            $table->dropColumn([
                'gelar_depan',
                'gelar_belakang',
                'tanggal_lahir',
                'no_str',
                'str_berlaku_sampai',
                'no_sip',
                'sip_berlaku_sampai',
                'nomor_kartu',
                'alamat_kartu',
                'rt_kartu',
                'rw_kartu',
                'kode_pos_kartu',
                'province_id_kartu',
                'regency_id_kartu',
                'district_id_kartu',
                'village_id_kartu',
                'rt',
                'rw',
                'kode_pos',
                'province_id',
                'regency_id',
                'district_id',
                'village_id',
            ]);
        });
    }
};
