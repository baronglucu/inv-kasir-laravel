<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // RAM : Socket : Core, Storage : Slot, BIOS, 
    public function up(): void
    {
        Schema::create('data_servers', function (Blueprint $table) {
            $table->id();
            $table->string('serialNumber', 30);
            $table->string('sisops', 100)->nullable();
            $table->integer('socket');
            $table->integer('core');
            $table->integer('slot');
            $table->string('bios', 50)->nullable();
            $table->string('scsi', 2)->nullable();
            $table->integer('hdisk')->nullable();
            $table->text('descrip')->nullable();
            $table->unsignedBigInteger('user_id');            
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
