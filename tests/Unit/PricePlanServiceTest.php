<?php

namespace Tests\Unit;

use App\Exceptions\InvalidMeterIdException;
use App\Repository\ElectricityReadingRepository;
use App\Repository\PricePlanRepository;
use App\Services\MeterReadingService;
use App\Services\PricePlanService;
use stdClass;
use Tests\TestCase;

class PricePlanServiceTest extends TestCase
{


    private $pricePlanService;

    private $electricityReadingRepositoryMock;
    private $pricePlanRepositoryMock;

    protected function setUp(): void
    {
        $this->electricityReadingRepositoryMock = $this->createMock(ElectricityReadingRepository::class);
        $this->pricePlanRepositoryMock = $this->createMock(PricePlanRepository::class);
        $meterReadingService = new MeterReadingService($this->electricityReadingRepositoryMock, $this->pricePlanRepositoryMock);
        $this->pricePlanService = new PricePlanService($meterReadingService, $this->pricePlanRepositoryMock);

    }

    /**
     * @test
     * @throws InvalidMeterIdException
     */
    public function get_Electricity_Consumption_Should_Return_Price_Plans_For_Valid_Electricity_Readings()
    {

        $pricePlans = $this->pricePlanService->getConsumptionCostOfElectricityReadingsForEachPricePlan("smart-meter-1");
        $this->assertNotNull($pricePlans);
    }

    /**
     * @test
     */
    public function get_Electricity_Consumption_Should_Throw_Exception_When_Readings_Not_Available()
    {
        $pricePlan = [];
        $pricePlan['supplier'] = 'The Green Eco';
        $pricePlan['unit_rate'] = '0.034455';

        $expectedReadings = collect([]);
        $this->electricityReadingRepositoryMock->method('getElectricityReadings')->willReturn($expectedReadings);

        $pricePlans = array($pricePlan);
        $this->pricePlanRepositoryMock->method('getPricePlans')->willReturn($pricePlans);


        $this->expectException(InvalidMeterIdException::class);
        $this->expectExceptionMessage("No electricity readings available for unknown-id");

        $this->pricePlanService->getConsumptionCostOfElectricityReadingsForEachPricePlan("unknown-id");


    }

    /**
     * @test
     * @throws InvalidMeterIdException
     */
    public function get_Cost_Plan_For_All_Suppliers_For_Valid_Meter_Id()
    {
        $pricePlan = [];
        $pricePlan['supplier'] = 'The Green Eco';
        $pricePlan['unit_rate'] = '0.034455';

        $expectedReadings = collect([['reading' => '0.1212312', 'time' => '2021-10-08 20:19:27']]);
        $this->electricityReadingRepositoryMock->method('getElectricityReadings')->willReturn($expectedReadings);

        $pricePlans = array($pricePlan);
        $this->pricePlanRepositoryMock->method('getPricePlans')->willReturn($pricePlans);

        $costPlans = $this->pricePlanService->getCostPlanForAllSuppliersWithCurrentSupplierDetails("smart-meter-1");
        $this->assertNotNull($costPlans);
    }

    /**
     * @test
     */
    public function get_Cost_Plan_For_All_Suppliers_Should_Throw_Exception_For_InValid_Meter_Id()
    {
        $pricePlan = [];
        $pricePlan['supplier'] = 'The Green Eco';
        $pricePlan['unit_rate'] = '0.034455';

        $availableSupplierId = new stdClass();
        $availableSupplierId->smartMeterId = '1';
        $availableSupplierId->supplier = 'The Green Eco';

        $expectedReadings = collect([]);
        $this->electricityReadingRepositoryMock->method('getElectricityReadings')->willReturn($expectedReadings);


        $this->pricePlanRepositoryMock->method('getPricePlans')->willReturn(array($pricePlan));

        $this->pricePlanRepositoryMock->method('getCurrentAvailableSupplierIds')->willReturn(array($availableSupplierId));

        $this->expectException(InvalidMeterIdException::class);
        $this->expectExceptionMessage("No electricity readings available for unknown-id");

        $this->pricePlanService->getCostPlanForAllSuppliersWithCurrentSupplierDetails("unknown-id");
    }

    /**
     * @test
     * @throws InvalidMeterIdException
     */
    public function get_Cost_Plan_For_All_Suppliers_Should_Return_Plans_With_Supplier_Info()
    {
        $pricePlan = [];
        $pricePlan['supplier'] = 'The Green Eco';
        $pricePlan['unit_rate'] = '0.034455';

        $availableSupplierId = new stdClass();
        $availableSupplierId->smartMeterId = '1';
        $availableSupplierId->supplier = 'The Green Eco';

        $expectedReadings = collect([['reading' => '0.1212312', 'time' => '2021-10-08 20:19:27']]);
        $this->electricityReadingRepositoryMock->method('getElectricityReadings')->willReturn($expectedReadings);
        $this->pricePlanRepositoryMock->method('getPricePlans')->willReturn(array($pricePlan));
        $this->pricePlanRepositoryMock->method('getCurrentAvailableSupplierIds')->willReturn(array($availableSupplierId));

        $costPlans = $this->pricePlanService->getCostPlanForAllSuppliersWithCurrentSupplierDetails("smart-meter-1");
        $supplier = end($costPlans);

        $this->assertEquals("The Green Eco", $supplier);
    }
}
