<?php

namespace App\Console\Commands;

use App\Models\Kamar;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpirePendingPenghuni extends Command
{
    protected $signature = 'penghuni:expire-pending';

    protected $description = 'Menandai calon penghuni yang melewati deadline pembayaran sebagai expired dan mengosongkan kamar';

    public function handle(): int
    {
        $expiredUsers = User::query()
            ->where('role', 'penghuni')
            ->where('status_pendaftaran', 'pending')
            ->whereNotNull('payment_deadline')
            ->where('payment_deadline', '<', now())
            ->get();

        $count = 0;

        foreach ($expiredUsers as $user) {
            DB::transaction(function () use ($user) {
                $user->update([
                    'status_pendaftaran' => 'expired',
                ]);

                if ($user->id_kamar) {
                    Kamar::where('id_kamar', $user->id_kamar)->update([
                        'status' => 'Tersedia',
                    ]);
                }
            });

            $count++;
        }

        $this->info("Expired {$count} calon penghuni.");

        return self::SUCCESS;
    }
}