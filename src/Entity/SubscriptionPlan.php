<?php

namespace App\Entity;

use App\Repository\SubscriptionPlanRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: SubscriptionPlanRepository::class)]
class SubscriptionPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le type du plan d'abonnement est obligatoire.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le type du plan d'abonnement ne peut pas dépasser {{ limit }} caractères." )]
    private ?string $Type = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le prix est obligatoire.")]
    #[Assert\Positive(message: "Le prix doit être un nombre positif.")]
    private ?float $Prix = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        min: 10,
        max: 1000,
        minMessage: "L'information additionnelle doit contenir au moins {{ limit }} caractères.",
        maxMessage: "L'information additionnelle ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $additionalInfo = null;



 #[ORM\OneToMany(targetEntity:Reservation::class, mappedBy:"subscriptionPlan")]
 
private Collection $reservations;

public function __construct()
{
    $this->reservations = new ArrayCollection();
}

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

    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(string $additionalInfo): static
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }

}
