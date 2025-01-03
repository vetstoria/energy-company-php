<?php

namespace App\Repository;

use App\Models\ElectricityReadings;
use App\Models\SmartMeter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ElectricityReadingRepository implements IElectricityReadingRepository
{
    public function getElectricityReadings($smartMeterId): Collection
    {
        return DB::table(ElectricityReadings::$tableName)
            ->join('smart_meters', 'electricity_readings.smart_meter_id', '=', 'smart_meters.id')
            ->where('smart_meters.smartMeterId', '=', $smartMeterId)
            ->get(['time', 'reading']);
    }

    public function getSmartMeterId($smartMeterId)
    {
        return SmartMeter::query()->where('smart_meters.smartMeterId', '=', $smartMeterId)
            ->first('smart_meters.id');
    }

    public function insertElectricityReadings($electricityReadingArray): bool
    {
        return ElectricityReadings::query()->insert($electricityReadingArray);
    }

    public function insertSmartMeter($smartMeter): int
    {
        return SmartMeter::query()->insertGetId($smartMeter);
    }
}
