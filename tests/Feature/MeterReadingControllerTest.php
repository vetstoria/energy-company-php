<?php

namespace Tests\Feature;

use Tests\TestCase;

class MeterReadingControllerTest extends TestCase
{
    public function test_getReadings()
    {
        $response = $this->get('/readings/smart-meter-1');

        $response->assertStatus(200);
    }

    public function test_getReadingsShouldReturnExceptionForInvalidSmartMeterId()
    {
        $response = $this->get('/readings/smart-meter-60');
        $this->assertEquals("No electricity readings available for smart-meter-60",  json_decode($response->content()));
    }

    public function test_storeReadings()
    {
        $response = $this->post('/readings', ['smartMeterId' => 'smart-meter-1', 'supplier' => 'The Green Eco',
            'electricityReadings' => [['time' => '6:00', 'reading' => 0.5656]]]);

        $response->assertStatus(201);
    }

}
