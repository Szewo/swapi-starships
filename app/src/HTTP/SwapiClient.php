<?php

declare(strict_types=1);

namespace App\HTTP;

use App\DTO\StarshipDTO;
use App\DTO\StarshipDTOMapper;
use App\Response\ResponseStatus;
use App\Response\SwapiResponse;
use App\Response\SwapiResponseInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SwapiClient implements SwapiClientInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private string $swapiUrl = '',
    ) {
    }

    public function getStarships(): SwapiResponseInterface
    {
        $clientResponse = new SwapiResponse();
        try {
            $result = $this->fetchAllStarships();
            $clientResponse->setContent($result);
        } catch (TransportExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface) {
            $clientResponse->setStatus(ResponseStatus::FAILURE);
            $clientResponse->setError('Error during fetching data from api.');
        } finally {
            return $clientResponse;
        }
    }

    /**
     * @return StarshipDTO[]
     *
     * @throws TransportExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface
     */
    private function fetchAllStarships(): array
    {
        $starships = [];
        do {
            $content = $this->getRequestContent();
            $starships = array_merge($starships, $content['results']);
            if ($content['next']) {
                $this->swapiUrl = $content['next'];
            }
        } while($content['next'] !== null);

        return StarshipDTOMapper::mapArrayToDto($starships);
    }

    /**
     * @return array{
     *     next: ?string,
     *     results: array<object{
     *             name: string,
     *             model: string,
     *             manufacturer: string,
     *             cost_in_credits: string,
     *             length: string,
     *             max_atmosphering_speed: string,
     *             crew: string,
     *             passengers: string,
     *             cargo_capacity: string,
     *             consumables: string,
     *             hyperdrive_rating: string,
     *             MGLT: string,
     *             starship_class: string,
     *             pilots: array{int, string},
     *             films: array{int, string},
     *             created: string,
     *             edited: string,
     *             url: string,
     *         }>}
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function getRequestContent(): array
    {
        $response = $this->client->request(
            method: 'GET',
            url: $this->swapiUrl,
        );
        $content = json_decode(
            json: $response->getContent(),
        );

        return [
            'next' => $content->next,
            'results' => $content->results,
        ];
    }

}
