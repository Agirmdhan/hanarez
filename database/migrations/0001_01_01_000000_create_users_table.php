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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user'); // ID unik pengguna sesuai SRS[cite: 1]
            $table->string('nama'); // Nama pengguna[cite: 1]
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // Menyimpan password (hash)[cite: 1]
            $table->enum('role', ['admin', 'penghuni'])->default('penghuni'); // Hak akses peran[cite: 1]
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif'); // Status akun[cite: 1]
            $table->enum('status_pendaftaran', ['pending', 'aktif', 'expired'])->default('pending');
            $table->timestamp('payment_deadline')->nullable();
            $table->timestamp('payment_completed_at')->nullable();
            $table->rememberToken();
            $table->timestamps(); // Mengelola created_at dan updated_at[cite: 1]
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};