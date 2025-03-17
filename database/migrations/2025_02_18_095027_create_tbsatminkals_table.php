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
        Schema::create('tbsatminkals', function (Blueprint $table) {
            $table->id();
            $table->string('kd_ktm');
            $table->string('kd_smkl');
            $table->string('ur_smkl');            
            $table->string('nm_jln');
            $table->string('nm_kota');
            $table->string('nm_prov');
            $table->string('no_telp');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbsatminkals');
    }
};
