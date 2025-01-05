<?php

namespace App\Repository;

use App\Models\PricePlan;
use Illuminate\Support\Facades\DB;

class PricePlanRepository implements IPricePlanRepository
{
    public function getRandomPricePlanId()
    {
        return PricePlan::query()->get('price_plans.id')->random();
    }

    public function getPricePlans(): array
    {
        return PricePlan::query()->get(['supplier', 'unit_rate'])->toArray();
    }

    public function getCurrentAvailableSupplierIds($smartMeterId): array
    {
        return DB::table('smart_meters')
            ->join('price_plans', 'smart_meters.price_plan_id', '=', 'price_plans.id')
            ->where('smart_meters.smartMeterId', '=', $smartMeterId)
            ->get(['smartMeterId', 'supplier'])->toArray();
    }
}
