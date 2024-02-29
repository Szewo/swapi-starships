<?php

declare(strict_types=1);

namespace App\HTTP;

use App\DTO\StarshipDTO;
use App\DTO\StarshipDTOMapper;
use App\Exception\InfrastructureException;
use App\Response\ResponseStatus;
use App\Response\SwapiResponse;
use App\Response\SwapiResponseInterface;
use stdClass;
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
        } catch (InfrastructureException $exception) {
            $clientResponse->setStatus(ResponseStatus::FAILURE);
            $clientResponse->setError($exception->getMessage());
        } finally {
            return $clientResponse;
        }
    }

    /**
     * @return StarshipDTO[]
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws InfrastructureException
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
     * @throws InfrastructureException
     */
    private function getRequestContent(): array
    {
        $response = $this->client->request(
            method: 'GET',
            url: $this->swapiUrl,
        );
        if (json_validate($response->getContent())) {
            $content = json_decode(
                json: $response->getContent(),
            );
            assert($content instanceof stdClass);
            assert(property_exists($content, 'next'));
            assert(isset($content->results));

            return [
                'next' => $content->next,
                'results' => $content->results,
            ];
        }
        throw new InfrastructureException('Error during validating json response');
    }

}
