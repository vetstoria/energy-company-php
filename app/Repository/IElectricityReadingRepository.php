<?php

namespace App\Repository;


use Illuminate\Support\Collection;

interface IElectricityReadingRepository
{

    /**
     * @param $smartMeterID
     * @return Collection
     */
    function getElectricityReadings($smartMeterID): Collection;

    /**
     * @param $smartMeterID
     * @return mixed
     */
    function getSmartMeterId($smartMeterID);

    /**
     * @param $electricityReadingArray
     * @return bool
     */
    function insertElectricityReadings($electricityReadingArray): bool;

    /**
     * @param $smartMeter
     * @return int
     */
    function insertSmartMeter($smartMeter): int;
}
