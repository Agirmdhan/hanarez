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
    Schema::create('penghunis', function (Blueprint $table) {
        $table->id('id_penghuni');
        $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
        $table->string('nik', 16)->unique();
        $table->string('no_telepon', 15);
        $table->text('alamat');
        $table->string('kontak_darurat', 15)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghunis');
    }
};
