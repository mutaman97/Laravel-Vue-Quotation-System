<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Api\V1\Agent\Quotation;
use App\Models\Api\V1\Agent\Agent;

class QuotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agents = Agent::all();

        foreach ($agents as $agent) {
            Quotation::factory()->count(5)->create(['agent_id' => $agent->id]); // Each agent creates 5 quotations
        }
    }
}
