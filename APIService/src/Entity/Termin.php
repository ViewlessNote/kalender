<?php

namespace App\Entity;

use App\Repository\TerminRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerminRepository::class)]
class Termin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $Start = null;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $Ende = null;

    #[ORM\Column]
    private ?bool $Aufgabe = null;

    #[ORM\Column]
    private ?bool $Aktiv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Details = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->Start;
    }

    public function setStart(\DateTimeInterface $Start): static
    {
        $this->Start = $Start;

        return $this;
    }

    public function getEnde(): ?\DateTimeInterface
    {
        return $this->Ende;
    }

    public function setEnde(\DateTimeInterface $Ende): static
    {
        $this->Ende = $Ende;

        return $this;
    }

    public function isAufgabe(): ?bool
    {
        return $this->Aufgabe;
    }

    public function setAufgabe(bool $Aufgabe): static
    {
        $this->Aufgabe = $Aufgabe;

        return $this;
    }

    public function isAktiv(): ?bool
    {
        return $this->Aktiv;
    }

    public function setAktiv(bool $Aktiv): static
    {
        $this->Aktiv = $Aktiv;

        return $this;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->Details;
    }

    public function setDetails(?string $Details): static
    {
        $this->Details = $Details;

        return $this;
    }
}
