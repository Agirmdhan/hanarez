<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'status_pendaftaran')) {
                $table->enum('status_pendaftaran', ['pending', 'aktif', 'expired'])
                    ->default('pending')
                    ->after('status');
            }

            if (! Schema::hasColumn('users', 'payment_deadline')) {
                $table->timestamp('payment_deadline')
                    ->nullable()
                    ->after('status_pendaftaran');
            }

            if (! Schema::hasColumn('users', 'payment_completed_at')) {
                $table->timestamp('payment_completed_at')
                    ->nullable()
                    ->after('payment_deadline');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'payment_completed_at')) {
                $table->dropColumn('payment_completed_at');
            }

            if (Schema::hasColumn('users', 'payment_deadline')) {
                $table->dropColumn('payment_deadline');
            }

            if (Schema::hasColumn('users', 'status_pendaftaran')) {
                $table->dropColumn('status_pendaftaran');
            }
        });
    }
};