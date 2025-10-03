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
        Schema::create('data_perangkats', function (Blueprint $table) {
            $table->id();
            $table->string('serialNumber', 30);
            $table->string('merk', 50);
            $table->string('model', 100);
            $table->string('kapasitas', 50)->nullable();
            $table->string('storage', 50)->nullable();
            $table->string('kode_jns', 2)->nullable();
            $table->string('kodeRak', 5);
            $table->string('ip_address', 30)->nullable();
            $table->string('kondisi', 2); 
            $table->date('tgl_aktif');
            $table->string('sistemOperasi', 100)->nullable();
            $table->string('peruntukan', 50)->nullable();  
            $table->string('kd_ktm', 2)->nullable();
            $table->string('kd_smkl', 6)->nullable();
            $table->string('status', 2);
            $table->string('id_mitra', 50)->nullable();
            $table->string('id_apl', 50)->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('user_id');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_perangkats');
    }
};
