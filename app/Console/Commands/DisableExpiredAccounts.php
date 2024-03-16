<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\User;
use Illuminate\Console\Command;

class DisableExpiredAccounts extends Command
{
    protected $signature = 'accounts:disable';

    protected $description = 'Disable expired user accounts';

    public function handle()
    {
        try {
            // Find expired users
            $expiredUsers = User::where('account_expiration_date', '<', now())->get();

            // Disable expired users and update is_active field
            foreach ($expiredUsers as $user) {
                $user->status = false;
                $user->save();
                $this->info('Disabled user with ID: ' . $user->id);
            }

            // Output results
            $this->info(count($expiredUsers) . ' expired accounts disabled successfully.');
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}
