<?php

declare(strict_types=1);

namespace App\Tests\DTO;

use App\DTO\StarshipDTO;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StarshipDTO::class)]
final class StarshipsDTOTest extends TestCase
{
    public function testCanReturnProperValues(): void
    {
        $instance = new StarshipDTO(
            name: 'Test Name',
            model: 'Model',
            starshipClass: 'Class',
            manufacturer: 'Manufacturer',
            costInCredits: '100000',
            length: '1000',
            crew: 'Crew',
            passengers: 'passengers',
            maxAtmospheringSpeed: '100000',
            hyperdriveRating: 2.0,
            mglt: 'MGLT',
            cargoCapacity: 'Cargo Capacity',
            consumables: 'Consumables'
        );

        $this->assertSame(
            expected: 'Test Name',
            actual: $instance->name,
        );
        $this->assertSame(
            expected: 'Model',
            actual: $instance->model,
        );
        $this->assertSame(
            expected: 'Class',
            actual: $instance->starshipClass,
        );
        $this->assertSame(
            expected: 'Manufacturer',
            actual: $instance->manufacturer,
        );
        $this->assertSame(
            expected: '100000',
            actual: $instance->costInCredits,
        );
        $this->assertSame(
            expected: '1000',
            actual: $instance->length,
        );
        $this->assertSame(
            expected: 'Crew',
            actual: $instance->crew,
        );
        $this->assertSame(
            expected: 'passengers',
            actual: $instance->passengers,
        );
        $this->assertSame(
            expected: '100000',
            actual: $instance->maxAtmospheringSpeed,
        );
        $this->assertSame(
            expected: 2.0,
            actual: $instance->hyperdriveRating,
        );
        $this->assertSame(
            expected: 'MGLT',
            actual: $instance->mglt,
        );
        $this->assertSame(
            expected: 'Cargo Capacity',
            actual: $instance->cargoCapacity,
        );
        $this->assertSame(
            expected: 'Consumables',
            actual: $instance->consumables,
        );
    }

}