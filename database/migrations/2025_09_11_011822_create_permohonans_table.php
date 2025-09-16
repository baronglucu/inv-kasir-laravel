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
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('no_mohon')->nullable();
            $table->string('kd_ktm')->nullable();
            $table->string('kd_smkl')->nullable();
            $table->string('no_surat')->nullable();
            $table->date('tgl_surat')->nullable();
            $table->text('perihal')->nullable();
            $table->string('utk_satuan')->nullable();
            $table->string('nm_domain')->nullable();
            $table->string('status')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->string('melalui')->nullable();
            $table->string('file_surat')->nullable();
            $table->unsignedBigInteger('id_domain');
            $table->foreign('id_domain')->references('id')->on('domains')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
