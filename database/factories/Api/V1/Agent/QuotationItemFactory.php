<?php

namespace Database\Factories\Api\V1\Agent;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Api\V1\Agent\Quotation;
use App\Models\Api\V1\Admin\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Api\V1\Agent\QuotationItem>
 */
class QuotationItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quotation_id' => Quotation::factory(),
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
