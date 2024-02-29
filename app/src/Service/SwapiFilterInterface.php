<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\StarshipDTO;
use App\Exception\ApplicationException;

interface SwapiFilterInterface
{
    /**
     * @return StarshipDTO[]
     *
     * @throws ApplicationException
     */
    public function getFilteredStarships(): array;
}
