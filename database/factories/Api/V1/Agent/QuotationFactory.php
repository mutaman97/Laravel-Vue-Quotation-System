<?php

namespace Database\Factories\Api\V1\Agent;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Api\V1\Agent\Agent;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Api\V1\Agent\Quotation>
 */
class QuotationFactory extends Factory
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
            'total_price' => $this->faker->randomFloat(2, 100, 5000),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
