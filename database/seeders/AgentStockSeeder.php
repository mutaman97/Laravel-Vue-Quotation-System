<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Api\V1\Admin\AgentStock;
use App\Models\Api\V1\Agent\Agent;
use App\Models\Api\V1\Admin\Product;

class AgentStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agents = Agent::all();
        $products = Product::all();

        foreach ($agents as $agent) {
            foreach ($products->random(20) as $product) { // Assign 20 random products to each agent
                AgentStock::factory()->create([
                    'agent_id' => $agent->id,
                    'product_id' => $product->id,
                    'quantity' => rand(10, 100), // Random stock quantity
                ]);
            }
        }
    }
}
