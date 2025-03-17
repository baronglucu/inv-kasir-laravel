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
        Schema::create('log_produks', function (Blueprint $table) {
            $table->id();
            $table->string('serialNumber');
            $table->string('kon_lama');
            $table->string('kon_baru');
            $table->string('kodeRak');
            $table->unsignedBigInteger('UserId');
            $table->timestamps();
        });

        DB::unprepared(
            "create trigger log_produk
            After update on produks
            For each row
            Begin 
                insert into log_produks (serialNumber, kon_lama, kon_baru, kodeRak, UserId, created_at, updated_at)
                values (new.serialNumber, old.kondisi, new.kondisi, new.kodeRak, new.user_id, Now(), Now());
            End;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_produks');
    }
};
