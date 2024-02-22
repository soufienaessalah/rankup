<?php

namespace App\Entity;

use App\Repository\SubscriptionPlanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionPlanRepository::class)]
class SubscriptionPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\Column]
    private ?float $Prix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): static
    {
        $this->Prix = $Prix;

        return $this;
    }
}
