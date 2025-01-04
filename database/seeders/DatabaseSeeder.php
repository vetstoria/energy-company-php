<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\SmartMeter;
use \App\Models\ElectricityReadings;
use \App\Models\PricePlan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        PricePlan::factory()->count(3)
            ->sequence(
                ['planName' => 'price-plan-0', 'supplier' => 'Dr Evils Dark Energy', 'unitRate' => 10],
                ['planName' => 'price-plan-1', 'supplier' => 'The Green Eco', 'unitRate' => 20],
                ['planName' => 'price-plan-2', 'supplier' => 'Power for Everyone', 'unitRate' => 5],
            )
            ->create();
        SmartMeter::factory()->count(5)
            ->sequence(
                ['smartMeterId' => 'smart-meter-0', 'price_plan_id' => '1'],
                ['smartMeterId' => 'smart-meter-1', 'price_plan_id' => '2'],
                ['smartMeterId' => 'smart-meter-2', 'price_plan_id' => '1'],
                ['smartMeterId' => 'smart-meter-3', 'price_plan_id' => '3'],
                ['smartMeterId' => 'smart-meter-4', 'price_plan_id' => '2'],
            )
            ->create();
        ElectricityReadings::factory(5)->create();
    }
}
