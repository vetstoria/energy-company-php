<?php

namespace Tests\Feature;

use Tests\TestCase;

class PricePlanComparatorControllerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowExceptionWhenNoReadingsAvailableForRecommendedPlans()
    {
        $response = $this->get('price-plans/recommend/smart-meter-70?limit=4');
        self::assertEquals("No electricity readings available for smart-meter-70", json_decode($response->content()));
    }

    /**
     * @test
     */

    public function shouldReturnRecommendedPlans()
    {
        $response = $this->get('price-plans/recommend/smart-meter-1?limit=1');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenNoReadingsAvailableForComparePricePlans()
    {
        $response = $this->get('price-plans/compare-all/smart-meter-70');
        self::assertEquals("No electricity readings available for smart-meter-70", json_decode($response->content()));
    }

    /**
     * @test
     */

    public function shouldReturnComparedCostPlans()
    {
        $response = $this->get('price-plans/compare-all/smart-meter-1');
        $response->assertStatus(200);
    }
}
