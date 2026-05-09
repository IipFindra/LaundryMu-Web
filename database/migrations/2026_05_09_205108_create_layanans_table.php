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
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tipe');
            $table->string('waktu');
            $table->integer('harga');
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('Aktif');
            $table->string('ikon')->default('local_laundry_service');
            $table->string('warna_ikon')->default('bg-blue-100 text-blue-500');
            $table->string('warna_tipe')->default('bg-blue-100 text-blue-700');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
