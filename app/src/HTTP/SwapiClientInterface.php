<?php

declare(strict_types=1);

namespace App\HTTP;

use App\Response\SwapiResponseInterface;

interface SwapiClientInterface
{
    public function getStarships(): SwapiResponseInterface;
}
