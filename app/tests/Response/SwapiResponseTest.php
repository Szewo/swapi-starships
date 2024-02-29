<?php

declare(strict_types=1);

namespace App\Tests\Response;

use App\DTO\StarshipDTO;
use App\Response\ResponseStatus;
use App\Response\SwapiResponse;
use App\Response\SwapiResponseInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SwapiResponse::class)]
#[UsesClass(StarshipDTO::class)]
final class SwapiResponseTest extends TestCase
{
    private SwapiResponseInterface $instance;

    protected function setUp() : void
    {
        parent::setUp();
        $this->instance = new SwapiResponse();
    }

    public function testCanBeCreatedWithDefaultValues(): void
    {
        $this->assertSame(
            expected: null,
            actual: $this->instance->getStatus()
        );
        $this->assertSame(
            expected: [],
            actual: $this->instance->getContent()
        );
        $this->assertSame(
            expected: 'Something went wrong',
            actual: $this->instance->getError()
        );
    }

    public function testCanReturnSuccessStatus(): void
    {
        $this->instance->setStatus(ResponseStatus::SUCCESS);

        $this->assertSame(
            expected: ResponseStatus::SUCCESS,
            actual: $this->instance->getStatus(),
        );
    }

    public function testCanReturnFailureStatus(): void
    {
        $this->instance->setStatus(ResponseStatus::FAILURE);

        $this->assertSame(
            expected: ResponseStatus::FAILURE,
            actual: $this->instance->getStatus(),
        );
    }

    public function testCanReturnError(): void
    {
        $this->instance->setError('Test error');

        $this->assertSame(
            expected: 'Test error',
            actual: $this->instance->getError(),
        );
    }

    #[DataProvider('starshipsProvider')]
    public function testCanReturnContent(array $starships): void
    {
        $this->instance->setContent(
            content: $starships,
        );

        $this->assertIsArray(
            actual: $this->instance->getContent(),
        );
    }

    /**
     * @return array<StarshipDTO>
     */
    public static function starshipsProvider(): array
    {
        return [
            'starships' => [
                [
                    new StarshipDTO(
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
                    ),
                ],
            ]
        ];
    }
}
