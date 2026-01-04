<?php

namespace Database\Seeders;

use App\Models\ShippingRule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingRule::create([
        'district_id' => null,
        'upazila_id' => null,
        'charge' => 130,
    ]);

    ShippingRule::create([
        'district_id' => 14,
        'upazila_id' => null,
        'charge' => 60,
    ]);
    }
}
