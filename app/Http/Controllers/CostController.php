<?php

namespace App\Http\Controllers;
use App\Exceptions\InvalidMeterIdException;
use App\Services\MeterReadingService;
use Illuminate\Http\JsonResponse;

class CostController extends Controller
{
    private $meterReadingService;

    public function __construct(MeterReadingService $meterReadingService)
    {
        $this->meterReadingService = $meterReadingService;
    }

    public function getWeeklyCost($smartMeterId): JsonResponse
    {
        try {
            $electricityReadings = $this->meterReadingService->getReadings($smartMeterId);
            return response()->json($electricityReadings);
        } catch (InvalidMeterIdException $exception) {
            return response()->json($exception->getMessage());
        }
    }

}
