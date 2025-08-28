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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('no_lapor');
            $table->string('nama_pelapor');
            $table->date('tgl_laporan');
            $table->string('kd_ktm')->nullable();
            $table->string('kd_smkl')->nullable();
            $table->string('no_telp');
            $table->string('id_domain');
            $table->text('masalah');
            $table->text('solusi')->nullable();
            $table->string('status')->default('Pending');
            $table->string('klasifikasi')->nullable();
            $table->string('melalui')->nullable();
            $table->string('no_surat')->nullable();
            $table->date('tgl_surat')->nullable();
            $table->string('file_surat')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
