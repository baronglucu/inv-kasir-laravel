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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('nama_domain');   
            $table->string('hosting');
            $table->string('framework');         
            $table->string('status'); //error, running, maintenance, suspended
            $table->string('id_whm'); //id whm
            $table->string('tgl_aktif');
            $table->string('kd_ktm');
            $table->string('kd_smkl');
            $table->string('keterangan');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
