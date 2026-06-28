<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->string('bulan', 7);
            $table->string('bukti_pembayaran');
            $table->enum('status', ['menunggu', 'lunas'])->default('menunggu');
            $table->timestamps();

            $table->unique(['id_user', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
