<?php

namespace Tests\Unit;

use App\Exceptions\InvalidMeterIdException;
use App\Repository\ElectricityReadingRepository;
use App\Repository\PricePlanRepository;
use App\Services\MeterReadingService;
use stdClass;
use Tests\TestCase;


class MeterReadingServiceTest extends TestCase
{
    private $meterReadingService;
    private $electricityReadingRepositoryMock;
    private $pricePlanRepositoryMock;

    protected function setUp(): void
    {
        $this->electricityReadingRepositoryMock = $this->createMock(ElectricityReadingRepository::class);
        $this->pricePlanRepositoryMock = $this->createMock(PricePlanRepository::class);
        $this->meterReadingService = new MeterReadingService($this->electricityReadingRepositoryMock, $this->pricePlanRepositoryMock);
    }

    /**
     * @test
     */
    public function shouldReturnReadingsForValidMeterId()
    {
        $expectedReadings = collect(['reading' => '0.1212312', 'time' => '2021-10-08 20:19:27']);
        $this->electricityReadingRepositoryMock->method('getElectricityReadings')->willReturn($expectedReadings);

        $actualReadings = $this->meterReadingService->getReadings("smart-meter-1");

        $this->assertEquals($expectedReadings, $actualReadings);
    }

    /**
     * @test
     */
    public function shouldReturnExceptionMessageForInvalidMeterId()
    {
        $this->expectException(InvalidMeterIdException::class);
        $this->expectExceptionMessage("No electricity readings available for unknown-id");
        $this->electricityReadingRepositoryMock->method('getElectricityReadings')->willReturn(collect([]));
        $this->meterReadingService->getReadings("unknown-id");
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfReadingsAreInsertedForAvailableSmartMeter()
    {
        $smartMeterIdMock = new stdClass();
        $smartMeterIdMock->id = '1';
        $this->electricityReadingRepositoryMock->method('getSmartMeterId')->willReturn($smartMeterIdMock);
        $this->electricityReadingRepositoryMock->method('insertElectricityReadings')->willReturn(true);

        $this->assertTrue($this->meterReadingService->storeReadings("smart-meter-1", [['reading' => '0.1212312', 'time' => '2021-10-08 20:19:27']]));
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfReadingsAreInsertedForNewSmartMeter()
    {
        $pricePlanIdMock = new stdClass();
        $pricePlanIdMock->id = '1';
        $this->electricityReadingRepositoryMock->method('getSmartMeterId')->willReturn(null);
        $this->pricePlanRepositoryMock->method('getRandomPricePlanId')->willReturn($pricePlanIdMock);
        $this->electricityReadingRepositoryMock->method('insertElectricityReadings')->willReturn(true);
        $this->electricityReadingRepositoryMock->method('insertSmartMeter')->willReturn(1);

        $this->assertTrue($this->meterReadingService->storeReadings("smart-meter-1", [['reading' => '0.1212312', 'time' => '2021-10-08 20:19:27']]));
    }

    /**
     * @test
     */
    public function shouldReturnExceptionForInvalidSmartMeterIdPattern()
    {
        $this->expectException(InvalidMeterIdException::class);
        $this->expectExceptionMessage("Smart meter id should follow defined pattern (Ex: smart-meter-1)");
        $this->meterReadingService->storeReadings("invalid-id", [['reading' => '0.1212312', 'time' => '2021-10-08 20:19:27']]);
    }



}
