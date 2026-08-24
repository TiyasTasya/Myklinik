<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $regionFks = [
            ['pasiens', 'pasiens_province_id_foreign'],
            ['pasiens', 'pasiens_province_id_kartu_foreign'],
            ['pasiens', 'pasiens_regency_id_foreign'],
            ['pasiens', 'pasiens_regency_id_kartu_foreign'],
            ['pasiens', 'pasiens_tempat_lahir_regency_id_foreign'],
            ['pasiens', 'pasiens_district_id_foreign'],
            ['pasiens', 'pasiens_district_id_kartu_foreign'],
            ['pasiens', 'pasiens_village_id_foreign'],
            ['pasiens', 'pasiens_village_id_kartu_foreign'],
            ['pasien_keluargas', 'pasien_keluargas_province_id_foreign'],
            ['pasien_keluargas', 'pasien_keluargas_regency_id_foreign'],
            ['pasien_keluargas', 'pasien_keluargas_district_id_foreign'],
            ['pasien_keluargas', 'pasien_keluargas_village_id_foreign'],
            ['pegawais', 'pegawais_province_id_foreign'],
            ['pegawais', 'pegawais_province_id_kartu_foreign'],
            ['pegawais', 'pegawais_regency_id_foreign'],
            ['pegawais', 'pegawais_regency_id_kartu_foreign'],
            ['pegawais', 'pegawais_tempat_lahir_regency_id_foreign'],
            ['pegawais', 'pegawais_district_id_foreign'],
            ['pegawais', 'pegawais_district_id_kartu_foreign'],
            ['pegawais', 'pegawais_village_id_foreign'],
            ['pegawais', 'pegawais_village_id_kartu_foreign'],
        ];

        foreach ($regionFks as $fk) {
            try {
                DB::statement("ALTER TABLE {$fk[0]} DROP FOREIGN KEY {$fk[1]}");
            } catch (\Throwable $e) {
                // Ignore if constraint does not exist
            }
        }

        DB::statement('ALTER TABLE pasiens MODIFY province_id VARCHAR(10) NULL');
        DB::statement('ALTER TABLE pasiens MODIFY regency_id VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pasiens MODIFY district_id VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pasiens MODIFY village_id VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pasiens MODIFY tempat_lahir_regency_id VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pasiens MODIFY province_id_kartu VARCHAR(10) NULL');
        DB::statement('ALTER TABLE pasiens MODIFY regency_id_kartu VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pasiens MODIFY district_id_kartu VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pasiens MODIFY village_id_kartu VARCHAR(20) NULL');

        DB::statement('ALTER TABLE pasien_keluargas MODIFY province_id VARCHAR(10) NULL');
        DB::statement('ALTER TABLE pasien_keluargas MODIFY regency_id VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pasien_keluargas MODIFY district_id VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pasien_keluargas MODIFY village_id VARCHAR(20) NULL');

        DB::statement('ALTER TABLE pegawais MODIFY province_id VARCHAR(10) NULL');
        DB::statement('ALTER TABLE pegawais MODIFY regency_id VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pegawais MODIFY district_id VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pegawais MODIFY village_id VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pegawais MODIFY tempat_lahir_regency_id VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pegawais MODIFY province_id_kartu VARCHAR(10) NULL');
        DB::statement('ALTER TABLE pegawais MODIFY regency_id_kartu VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pegawais MODIFY district_id_kartu VARCHAR(20) NULL');
        DB::statement('ALTER TABLE pegawais MODIFY village_id_kartu VARCHAR(20) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
