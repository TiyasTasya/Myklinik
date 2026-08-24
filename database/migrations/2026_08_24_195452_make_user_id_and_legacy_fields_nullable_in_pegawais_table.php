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
        DB::statement('ALTER TABLE pegawais MODIFY user_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE pegawais MODIFY tempat_tanggal_lahir VARCHAR(255) NULL');
        DB::statement('ALTER TABLE pegawais MODIFY alamat TEXT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
