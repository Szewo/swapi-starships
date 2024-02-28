<?php

declare(strict_types=1);

namespace App\Response;

use App\DTO\StarshipDTO;

interface SwapiResponseInterface
{
    public function getStatus(): ?ResponseStatus;

    public function setStatus(ResponseStatus $status): void;

    public function setError(string $error): void;

    public function getError(): string;

    /**
     * @param StarshipDTO[] $content
     */
    public function setContent(array $content): void;

    /**
     * @return StarshipDTO[]
     */
    public function getContent(): array;

}
