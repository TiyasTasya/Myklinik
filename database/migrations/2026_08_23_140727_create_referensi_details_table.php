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
        Schema::create('referensi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referensi_id')->constrained('referensis')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('deskripsi');
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referensi_details');
    }
};
