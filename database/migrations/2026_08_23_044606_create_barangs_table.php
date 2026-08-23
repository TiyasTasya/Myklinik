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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('satuan_id')->constrained('satuans')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('merk')->nullable();
            $table->foreignId('penyedia_id')->constrained('penyedias')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('generik')->nullable();
            $table->enum('jenis_penggunaan', ['Obat Dalam', 'Obat Luar']);
            $table->unsignedInteger('stok_minimum')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
