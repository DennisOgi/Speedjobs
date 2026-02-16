<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class MakeAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This seeder promotes test@speedjobs.com to admin.
     */
    public function run(): void
    {
        $updated = User::where('email', 'test@speedjobs.com')
            ->update([
                'is_admin' => true,
                'is_paid' => true,
            ]);

        if ($updated) {
            $this->command->info('✓ test@speedjobs.com promoted to admin');
        } else {
            $this->command->warn('⚠ User test@speedjobs.com not found');
        }
    }
}
