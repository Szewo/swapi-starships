<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class StarshipDTO
{
    public function __construct(
        public string $name,
        public string $model,
        public string $starshipClass,
        public string $manufacturer,
        public string $costInCredits,
        public string $length,
        public string $crew,
        public string $passengers,
        public string $maxAtmospheringSpeed,
        public float $hyperdriveRating,
        public string $mglt,
        public string $cargoCapacity,
        public string $consumables,
    ) {
    }
}
