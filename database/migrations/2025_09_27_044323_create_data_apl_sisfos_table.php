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
        Schema::create('data_apl_sisfos', function (Blueprint $table) {
            $table->id();
            $table->string('id_apl','20');
            $table->string('nama_apl','100');
            $table->string('ip_add','100');
            $table->string('nm_dom','100')->nullable();
            $table->year('thn_ada');
            $table->string('status','2');
            $table->date('tgl_aktif');
            $table->string('kd_ktm','2')->nullable();
            $table->string('kd_smkl','6')->nullable();
            $table->string('lkt','100')->nullable();
            $table->string('jaringan','100')->nullable();
            $table->text('fungsi');
            $table->string('id_mitra','20')->nullable();
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
        Schema::dropIfExists('data_apl_sisfos');
    }
};
