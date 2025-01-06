<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidMeterIdException;
use App\Services\PricePlanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class PricePlanComparatorController extends Controller
{
    private $pricePlanService;

    public function __construct(PricePlanService $pricePlanService)
    {
        $this->pricePlanService = $pricePlanService;
    }

    public function recommendations($smartMeterId, Request $request): JsonResponse
    {
        $limit = $request->query('limit');

        try {
            $recommendedPlans = $this->pricePlanService->getConsumptionCostOfElectricityReadingsForEachPricePlan($smartMeterId);
        } catch (InvalidMeterIdException $exception) {
            return response()->json($exception->getMessage());
        }
        $recommendedPlansAfterSorting = $this->sortPlans($recommendedPlans);

        if ($limit != null && $limit < count($recommendedPlans)) {
            $recommendedPlansAfterSorting = array_slice($recommendedPlansAfterSorting, 0, $limit);
        }

        return response()->json($recommendedPlansAfterSorting);
    }

    /**
     * @throws InvalidMeterIdException
     */
    public function comparisons($smartMeterId): JsonResponse
    {
        try{
            $costPricePerPlans = $this->pricePlanService->getCostPlanForAllSuppliersWithCurrentSupplierDetails($smartMeterId);
        }catch(InvalidMeterIdException $exception){
            return response()->json($exception->getMessage());
        }
        return response()->json($costPricePerPlans);
    }


    private function sortPlans($recommendedPlans)
    {
        $recommendedPlansReading = array_column($recommendedPlans, 'cost');
        array_multisort($recommendedPlansReading, SORT_ASC, $recommendedPlans);
        return $recommendedPlans;
    }
}
