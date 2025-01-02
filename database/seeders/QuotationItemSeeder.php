<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Api\V1\Agent\QuotationItem;
use App\Models\Api\V1\Agent\Quotation;
use App\Models\Api\V1\Admin\Product;

class QuotationItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quotations = Quotation::all();

        foreach ($quotations as $quotation) {
            foreach (Product::all()->random(5) as $product) { // Assign 5 random products to each quotation
                QuotationItem::factory()->create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 10), // Random quantity for quotation items
                    'price' => $product->price,
                ]);
            }
        }
    }
}
