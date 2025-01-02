<?php

namespace Database\Factories\Api\V1\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Api\V1\Agent\Agent;
use App\Models\api\V1\Admin\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Api\V1\Admin\AgentStock>
 */
class AgentStockFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'agent_id' => Agent::factory(),
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
