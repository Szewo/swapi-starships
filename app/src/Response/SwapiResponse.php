<?php

declare(strict_types=1);

namespace App\Response;

use App\DTO\StarshipDTO;

final class SwapiResponse implements SwapiResponseInterface
{
    private const string DEFAULT_ERROR = 'Something went wrong';

    /**
     * @param StarshipDTO[] $content
     */
    public function __construct(
        private ?ResponseStatus $status = null,
        private array $content = [],
        private string $error = self::DEFAULT_ERROR,
    ) {
    }

    public function getStatus(): ?ResponseStatus
    {
        return $this->status;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function setStatus(ResponseStatus $status): void
    {
        $this->status = $status;
    }

    public function setError(string $error): void
    {
        $this->error = $error;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function setContent(array $content): void
    {
        $this->content = $content;
    }

}
