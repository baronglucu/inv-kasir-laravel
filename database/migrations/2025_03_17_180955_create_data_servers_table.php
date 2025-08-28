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
        Schema::create('data_servers', function (Blueprint $table) {
            $table->id();
            $table->string('serialNumber');
            $table->string('merk');
            $table->string('model');
            $table->string('kapasitas');
            $table->foreignId('kodeRak');
            $table->string('ip_address');
            $table->string('kondisi'); 
            $table->date('tgl_aktif');
            $table->string('sistemOperasi');
            $table->string('peruntukan');   
            $table->string('kd_ktm')->nullable();
            $table->string('kd_smkl')->nullable();
            $table->string('status');
            $table->foreignId('id_mitra')->nullable();
            $table->string('keterangan')->nullable();
            $table->foreignId('user_id');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_servers');
    }
};
