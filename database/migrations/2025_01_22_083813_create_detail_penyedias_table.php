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
        Schema::create('detail_penyedias', function (Blueprint $table) {
            $table->id();
            $table->string('id_mitra');
            $table->string('nama_mitra');
            $table->string('notelp');
            $table->string('email');
            $table->string('alamat');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('alamat_web');
            $table->string('nama_pimpinan');
            $table->string('nohp_pimpinan');
            $table->string('email_pimpinan');
            $table->string('npwp');
            $table->string('siup');
            $table->string('keterangan');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penyedias');
    }
};
