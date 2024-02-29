<?php

declare(strict_types=1);

namespace App\Tests\HTTP;

use App\HTTP\SwapiClient;
use App\HTTP\SwapiClientInterface;
use App\Response\ResponseStatus;
use App\Response\SwapiResponseInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Exception\RedirectionException;
use Symfony\Component\HttpClient\Exception\ServerException;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

#[CoversClass(SwapiClient::class)]
final class SwapiClientTest extends TestCase
{
    private SwapiClientInterface $instance;

    private HttpClientInterface $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = \Mockery::mock(HttpClientInterface::class);

        $this->instance = new SwapiClient(
            client: $this->client,
        );
    }

    #[DataProvider('validJsonProvider')]
    public function testCanReturnPopperResponse(string $validJsonResponse): void
    {
        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getContent')
            ->andReturn($validJsonResponse);
        $this->client->shouldReceive('request')
            ->andReturn($response);

        $result = $this->instance->getStarships();

        $this->assertInstanceOf(
            expected: SwapiResponseInterface::class,
            actual: $result,
        );
        $this->assertSame(
            expected: ResponseStatus::SUCCESS,
            actual: $result->getStatus()
        );
        $this->assertNotEmpty(
            actual: $result->getContent(),
        );
    }

    public function testCanHandleTransportException(): void
    {
        $this->client->shouldReceive('request')
            ->andThrow(new TransportException());

        $result = $this->instance->getStarships();

        $this->assertInstanceOf(
            expected: SwapiResponseInterface::class,
            actual: $result,
        );
        $this->assertSame(
            expected: ResponseStatus::FAILURE,
            actual: $result->getStatus()
        );
        $this->assertSame(
            expected: 'Error during fetching data from api.',
            actual: $result->getError(),
        );
    }

    public function testCanHandleClientException(): void
    {
        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getInfo')
            ->with('http_code')
            ->andReturn(0);
        $response->shouldReceive('getInfo')
            ->with('url')
            ->andReturn(0);
        $response->shouldReceive('getInfo')
            ->with('response_headers')
            ->andReturn([]);

        $this->client->shouldReceive('request')
            ->andThrow(new ClientException($response));

        $result = $this->instance->getStarships();

        $this->assertInstanceOf(
            expected: SwapiResponseInterface::class,
            actual: $result,
        );
        $this->assertSame(
            expected: ResponseStatus::FAILURE,
            actual: $result->getStatus()
        );
        $this->assertSame(
            expected: 'Error during fetching data from api.',
            actual: $result->getError(),
        );
    }

    public function testCanHandleRedirectionException(): void
    {
        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getInfo')
            ->with('http_code')
            ->andReturn(0);
        $response->shouldReceive('getInfo')
            ->with('url')
            ->andReturn(0);
        $response->shouldReceive('getInfo')
            ->with('response_headers')
            ->andReturn([]);

        $this->client->shouldReceive('request')
            ->andThrow(new RedirectionException($response));

        $result = $this->instance->getStarships();

        $this->assertInstanceOf(
            expected: SwapiResponseInterface::class,
            actual: $result,
        );
        $this->assertSame(
            expected: ResponseStatus::FAILURE,
            actual: $result->getStatus()
        );
        $this->assertSame(
            expected: 'Error during fetching data from api.',
            actual: $result->getError(),
        );
    }

    public function testCanHandleServerException(): void
    {
        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getInfo')
            ->with('http_code')
            ->andReturn(0);
        $response->shouldReceive('getInfo')
            ->with('url')
            ->andReturn(0);
        $response->shouldReceive('getInfo')
            ->with('response_headers')
            ->andReturn([]);

        $this->client->shouldReceive('request')
            ->andThrow(new ServerException($response));

        $result = $this->instance->getStarships();

        $this->assertInstanceOf(
            expected: SwapiResponseInterface::class,
            actual: $result,
        );
        $this->assertSame(
            expected: ResponseStatus::FAILURE,
            actual: $result->getStatus()
        );
        $this->assertSame(
            expected: 'Error during fetching data from api.',
            actual: $result->getError(),
        );
    }

    #[DataProvider('invalidJsonProvider')]
    public function testCanHandleInvalidJson(string $invalidJson): void
    {
        $response = \Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getContent')
            ->andReturn($invalidJson);
        $this->client->shouldReceive('request')
            ->andReturn($response);

        $result = $this->instance->getStarships();

        $this->assertInstanceOf(
            expected: SwapiResponseInterface::class,
            actual: $result,
        );
        $this->assertSame(
            expected: ResponseStatus::FAILURE,
            actual: $result->getStatus()
        );
        $this->assertSame(
            expected: 'Error during validating json response',
            actual: $result->getError(),
        );
    }

    public static function validJsonProvider(): array
    {
        return [
            'validJson' => [
                '{
                   "count": 1,
                   "next": null,
                   "results": [
                       {
                           "name": "CR90 corvette",
                           "model": "CR90 corvette",
                           "manufacturer": "Corellian Engineering Corporation",
                           "cost_in_credits": "3500000",
                           "length": "150",
                           "max_atmosphering_speed": "950",
                           "crew": "30-165",
                           "passengers": "600",
                           "cargo_capacity": "3000000",
                           "consumables": "1 year",
                           "hyperdrive_rating": "2.0",
                           "MGLT": "60",
                           "starship_class": "corvette",
                           "pilots": [],
                           "films": [
                               "https://swapi.dev/api/films/1/",
                               "https://swapi.dev/api/films/3/",
                               "https://swapi.dev/api/films/6/"
                           ],
                           "created": "2014-12-10T14:20:33.369000Z",
                           "edited": "2014-12-20T21:23:49.867000Z",
                           "url": "https://swapi.dev/api/starships/2/"
                       }
                   ]
               }'
            ]
        ];
    }

    public static function invalidJsonProvider(): array
    {
        return [
            'invalidJson' => [
                '{
                                count 1
                                next null
                                "results": [
                                    {
                                        "name": "CR90 corvette",
                                        "model": "CR90 corvette",
                                        "manufacturer": "Corellian Engineering Corporation",
                                        "cost_in_credits": "3500000",
                                        "length": "150",
                                        "max_atmosphering_speed": "950",
                                        "crew": "30-165",
                                        "passengers": "600",
                                        "cargo_capacity": "3000000",
                                        "consumables": "1 year",
                                        "hyperdrive_rating": "2.0",
                                        "MGLT": "60",
                                        "starship_class": "corvette",
                                        "pilots": [],
                                        "films": [
                                            "https://swapi.dev/api/films/1/",
                                            "https://swapi.dev/api/films/3/",
                                            "https://swapi.dev/api/films/6/"
                                        ],
                                        "created": "2014-12-10T14:20:33.369000Z",
                                        "edited": "2014-12-20T21:23:49.867000Z",
                                        "url": "https://swapi.dev/api/starships/2/"
                                    }
                                ]
                            }'
            ]
        ];
    }

}
