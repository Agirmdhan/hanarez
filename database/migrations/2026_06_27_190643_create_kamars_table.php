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
    Schema::create('kamars', function (Blueprint $table) {
        $table->id('id_kamar');
        $table->string('nomor_kamar')->unique();
        $table->string('tipe');
        $table->decimal('harga', 10, 2);
        $table->text('fasilitas')->nullable();
        $table->enum('status', ['Tersedia', 'Dipesan', 'Terisi'])->default('Tersedia');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
