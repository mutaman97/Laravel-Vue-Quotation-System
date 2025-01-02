<?php

namespace Database\Seeders;

use Database\Seeders\UsersSeeder;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            AdminSeeder::class,
            AgentSeeder::class,
            ProductSeeder::class,
            AgentStockSeeder::class,
            QuotationSeeder::class,
            QuotationItemSeeder::class,
        ]);
    }
}
