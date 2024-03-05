<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StarshipRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StarshipRepository::class)]
final class Starship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $starshipClass = null;

    #[ORM\Column(length: 255, nullable: TRUE)]
    private ?string $manufacturer = null;

    #[ORM\Column(length: 255)]
    private ?string $costInCredits = null;

    #[ORM\Column(length: 255, nullable: TRUE)]
    private ?string $length = null;

    #[ORM\Column(length: 255)]
    private ?string $crew = null;

    #[ORM\Column(length: 255)]
    private ?string $passengers = null;

    #[ORM\Column(length: 255, nullable: TRUE)]
    private ?string $maxAtmospheringSpeed = null;

    #[ORM\Column]
    private ?float $hyperdriveRating = null;

    #[ORM\Column(length: 255, nullable: TRUE)]
    private ?string $mglt = null;

    #[ORM\Column(length: 255, nullable: TRUE)]
    private ?string $cargoCapacity = null;

    #[ORM\Column(length: 255)]
    private ?string $consumables = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): Starship
    {
        $this->name = $name;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): Starship
    {
        $this->model = $model;

        return $this;
    }

    public function getStarshipClass(): ?string
    {
        return $this->starshipClass;
    }

    public function setStarshipClass(string $starshipClass): Starship
    {
        $this->starshipClass = $starshipClass;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): Starship
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getCostInCredits(): ?string
    {
        return $this->costInCredits;
    }

    public function setCostInCredits(string $costInCredits): Starship
    {
        $this->costInCredits = $costInCredits;

        return $this;
    }

    public function getLength(): ?string
    {
        return $this->length;
    }

    public function setLength(string $length): Starship
    {
        $this->length = $length;

        return $this;
    }

    public function getCrew(): ?string
    {
        return $this->crew;
    }

    public function setCrew(string $crew): Starship
    {
        $this->crew = $crew;

        return $this;
    }

    public function getPassengers(): ?string
    {
        return $this->passengers;
    }

    public function setPassengers(string $passengers): Starship
    {
        $this->passengers = $passengers;

        return $this;
    }

    public function getMaxAtmospheringSpeed(): ?string
    {
        return $this->maxAtmospheringSpeed;
    }

    public function setMaxAtmospheringSpeed(string $maxAtmospheringSpeed): Starship
    {
        $this->maxAtmospheringSpeed = $maxAtmospheringSpeed;

        return $this;
    }

    public function getHyperdriveRating(): ?float
    {
        return $this->hyperdriveRating;
    }

    public function setHyperdriveRating(float $hyperdriveRating): Starship
    {
        $this->hyperdriveRating = $hyperdriveRating;

        return $this;
    }

    public function getMglt(): ?string
    {
        return $this->mglt;
    }

    public function setMglt(string $mglt): Starship
    {
        $this->mglt = $mglt;

        return $this;
    }

    public function getCargoCapacity(): ?string
    {
        return $this->cargoCapacity;
    }

    public function setCargoCapacity(string $cargoCapacity): Starship
    {
        $this->cargoCapacity = $cargoCapacity;

        return $this;
    }

    public function getConsumables(): ?string
    {
        return $this->consumables;
    }

    public function setConsumables(string $consumables): Starship
    {
        $this->consumables = $consumables;

        return $this;
    }
}
