<?php

namespace App\Repository;

interface IPricePlanRepository
{
    function getRandomPricePlanId();

    function getPricePlans(): array;

    function getCurrentAvailableSupplierIds($smartMeterId): array;
}
