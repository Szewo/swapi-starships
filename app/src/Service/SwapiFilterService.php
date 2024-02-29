<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\StarshipDTO;
use App\Exception\ApplicationException;
use App\HTTP\SwapiClientInterface;
use App\Response\ResponseStatus;

final readonly class SwapiFilterService implements SwapiFilterInterface
{
    private const float MIN_HYPERDRIVE_RATING = 2.0;

    public function __construct(
        private SwapiClientInterface $swapiClient,
    ) {
    }

    /**
     * @return StarshipDTO[]
     *
     * @throws ApplicationException
     */
    public function getFilteredStarships(): array
    {
        $response = $this->swapiClient->getStarships();
        if ($response->getStatus() === ResponseStatus::FAILURE) {
            throw new ApplicationException($response->getError());
        }

        return array_filter(
            array: $response->getContent(),
            callback: fn (StarshipDTO $starship) => $starship->hyperdriveRating >= self::MIN_HYPERDRIVE_RATING
        );
    }
}
