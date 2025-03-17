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
        Schema::create('tb_whms', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 50);
            $table->string('nama_whm', 50);
            $table->string('kodeRak', 4);
            $table->integer('kapasitas');
            $table->string('kondisi', 2);
            $table->date('tgl_aktif')->nullable();
            $table->date('tgl_akhir')->nullable();
            $table->integer('lama_ssl');
            $table->text('keterangan')->nullable();
            $table->text('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_whms');
    }
};
