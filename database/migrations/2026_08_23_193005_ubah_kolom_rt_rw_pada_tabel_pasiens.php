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
        Schema::table('pasiens', function (Blueprint $table) {
            $table->string('rt', 10)->nullable()->change();
            $table->string('rw', 10)->nullable()->change();
            $table->string('rt_kartu', 10)->nullable()->change();
            $table->string('rw_kartu', 10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->string('rt', 5)->nullable()->change();
            $table->string('rw', 5)->nullable()->change();
            $table->string('rt_kartu', 5)->nullable()->change();
            $table->string('rw_kartu', 5)->nullable()->change();
        });
    }
};
