<?php

declare(strict_types=1);

namespace App\Tests\DTO;

use App\DTO\StarshipDTO;
use App\DTO\StarshipDTOMapper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(StarshipDTOMapper::class)]
final class StarshipDTOMapperTest extends TestCase
{
    #[DataProvider('contentProvider')]
    public function testCanMapObjectToDto($content): void
    {
        $result = StarshipDTOMapper::mapArrayToDto($content);

        $this->assertIsArray(
            actual: $result
        );
        $this->assertCount(
            expectedCount: 1,
            haystack: $result
        );
        $this->assertInstanceOf(
            expected: StarshipDTO::class,
            actual: $result[0],
        );

        $this->assertSame(
            expected: 'CR90 corvette',
            actual: $result[0]->name
        );
        $this->assertSame(
            expected: 'Corellian Engineering Corporation',
            actual: $result[0]->model
        );
        $this->assertSame(
            expected: '3500000',
            actual: $result[0]->costInCredits
        );
        $this->assertSame(
            expected: '3500000',
            actual: $result[0]->length
        );
        $this->assertSame(
            expected: 'Test Manufacturer',
            actual: $result[0]->manufacturer
        );
        $this->assertSame(
            expected: '950',
            actual: $result[0]->maxAtmospheringSpeed
        );
        $this->assertSame(
            expected: '30-165',
            actual: $result[0]->crew
        );
        $this->assertSame(
            expected: '600',
            actual: $result[0]->passengers
        );
        $this->assertSame(
            expected: '3000000',
            actual: $result[0]->cargoCapacity
        );
        $this->assertSame(
            expected: '1 year',
            actual: $result[0]->consumables
        );
        $this->assertSame(
            expected: 2.0,
            actual: $result[0]->hyperdriveRating
        );
        $this->assertSame(
            expected: '60',
            actual: $result[0]->mglt
        );
        $this->assertSame(
            expected: 'corvette',
            actual: $result[0]->starshipClass
        );
    }

    public static function contentProvider(): array
    {
        $object = new StdClass();
        $object->name = 'CR90 corvette';
        $object->model = 'Corellian Engineering Corporation';
        $object->cost_in_credits = '3500000';
        $object->length = '3500000';
        $object->manufacturer = 'Test Manufacturer';
        $object->max_atmosphering_speed = '950';
        $object->crew = '30-165';
        $object->passengers = '600';
        $object->cargo_capacity = '3000000';
        $object->consumables = '1 year';
        $object->hyperdrive_rating = '2.0';
        $object->MGLT = '60';
        $object->starship_class = 'corvette';
        $object->pilots = [];
        $object->films = [];

        return [
            'content' =>
                [
                    [
                        0 => $object
                    ]
                ]
        ];
    }
}
