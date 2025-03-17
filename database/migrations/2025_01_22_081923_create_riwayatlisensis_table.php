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
        Schema::create('riwayatlisensis', function (Blueprint $table) {
            $table->id();
            $table->string('serialNumber');
            $table->string('no_invoice');
            $table->date('tgl_transaksi');
            $table->date('tgl_lisensi');
            $table->date('tgl_berakhir');
            $table->string('status');
            $table->string('idpenyedia');
            $table->unsignedBigInteger('idnorek');
            $table->decimal('harga', 10, 2);
            $table->unsignedBigInteger('user_id');  
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayatlisensis');
    }
};
