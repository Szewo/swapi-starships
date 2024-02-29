<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\DTO\StarshipDTO;
use App\Exception\ApplicationException;
use App\HTTP\SwapiClientInterface;
use App\Response\ResponseStatus;
use App\Response\SwapiResponseInterface;
use App\Service\SwapiFilterService;
use Mockery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SwapiFilterService::class)]
#[UsesClass(SwapiClientInterface::class)]
#[UsesClass(SwapiResponseInterface::class)]
final class SwapiFilterServiceTest extends TestCase
{
    private SwapiFilterService $instance;
    private SwapiClientInterface $swapiClient;
    private SwapiResponseInterface $swapiResponse;

    protected function setUp() : void
    {
        parent::setUp();
        $this->swapiResponse = Mockery::mock(SwapiResponseInterface::class);
        $this->swapiClient = Mockery::mock(SwapiClientInterface::class);
        $this->instance = new SwapiFilterService(
            swapiClient: $this->swapiClient,
        );
    }

    #[DataProvider('starshipsProvider')]
    public function testCanFilterArrayWithStarships(array $starships): void
    {
        $this->swapiResponse->shouldReceive('getStatus')
            ->andReturn(ResponseStatus::SUCCESS);
        $this->swapiResponse->shouldReceive('getContent')
            ->andReturn($starships);
        $this->swapiClient->shouldReceive('getStarships')
            ->andReturn($this->swapiResponse);

        $result = $this->instance->getFilteredStarships();

        $this->assertIsArray(
            actual: $result
        );
        $this->assertCount(
            expectedCount: 2,
            haystack: $result
        );
    }

    public function testCanThrowApplicationException(): void
    {
        $this->expectException(ApplicationException::class);

        $this->swapiResponse->shouldReceive('getStatus')
            ->andReturn(ResponseStatus::FAILURE);
        $this->swapiResponse->shouldReceive('getError')
            ->andReturn('Test application error message');
        $this->swapiClient->shouldReceive('getStarships')
            ->andReturn($this->swapiResponse);

        $this->instance->getFilteredStarships();
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
                        hyperdriveRating: 4.0,
                        mglt: 'MGLT',
                        cargoCapacity: 'Cargo Capacity',
                        consumables: 'Consumables'
                    ),
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
                        hyperdriveRating: 1.0,
                        mglt: 'MGLT',
                        cargoCapacity: 'Cargo Capacity',
                        consumables: 'Consumables'
                    )
                ],
            ]
        ];
    }
}
