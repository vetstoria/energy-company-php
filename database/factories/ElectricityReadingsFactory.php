<?php

namespace Database\Factories;

use App\Models\ElectricityReadings;
use App\Models\SmartMeter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElectricityReadingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ElectricityReadings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reading' => $this->faker->randomFloat(4, 0, 1),
            'time' => $this->faker->dateTimeThisYear(),
            'smart_meter_id' => function () {
                return SmartMeter::inRandomOrder()->first()->id;
            }
        ];
    }
}
