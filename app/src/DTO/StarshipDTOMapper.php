<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class StarshipDTOMapper
{
    /**
     * @param array<int, object{
     *     name: string,
     *     model: string,
     *     manufacturer: string,
     *     cost_in_credits: string,
     *     length: string,
     *     max_atmosphering_speed: string,
     *     crew: string,
     *     passengers: string,
     *     cargo_capacity: string,
     *     consumables: string,
     *     hyperdrive_rating: string,
     *     MGLT: string,
     *     starship_class: string,
     *     pilots: array<int, string>,
     *     films: array<int, string>,
     *     created: string,
     *     edited: string,
     *     url: string,
     * }> $content
     *
     * @return StarshipDTO[]
     */
    public static function mapArrayToDto(array $content): array
    {
        $starships = [];
        foreach ($content as $item) {
            $starships[] = new StarshipDTO(
                name: $item->name,
                model: $item->model,
                starshipClass: $item->starship_class,
                manufacturer: $item->manufacturer,
                costInCredits: $item->cost_in_credits,
                length: $item->length,
                crew: $item->crew,
                passengers: $item->passengers,
                maxAtmospheringSpeed: $item->max_atmosphering_speed,
                hyperdriveRating: (float) $item->hyperdrive_rating,
                mglt: $item->MGLT,
                cargoCapacity: $item->cargo_capacity,
                consumables: $item->consumables
            );
        }

        return $starships;
    }
}
