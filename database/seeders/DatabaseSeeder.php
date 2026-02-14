<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed test admin account (for Railway deployment)
        $this->call([
            TestAdminSeeder::class,
        ]);

        // Seed sample data
        \App\Models\Job::factory(50)->create();
    }
}
