<?php

namespace App\Entity;

use App\Repository\SuiviReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Reclamation;


#[ORM\Entity(repositoryClass: SuiviReclamationRepository::class)]
class SuiviReclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private ?int $id = null;

    #[ORM\Column(name: "idRec")]
    #[Assert\NotBlank(message:"id is required")]
    private ?int $idRec = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"status is required")]
    #[Assert\Length(  min : 5,
                    max :26,
                    minMessage :"status must be at least {{ limit }} characters long",
                    maxMessage : "status cannot be longer than {{ limit }} characters")]

     #[Assert\Choice(
                        choices: ["reçue", "en attente", "en cours de traitement", "traité"],
                        message: "Invalid type. Allowed types are reçue,en attente, en cours de traitement,traité"
     )]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"descripton is required")]
    #[Assert\length(min :8,
         max : 60,
         minMessage : "description must be at least {{ limit }} characters long",
         maxMessage : "description cannot be longer than {{ limit }} characters")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"date is required")]
    #[Assert\Range(
        min: "2024-01-01",
        max: "2024-12-31",
        minMessage: "Date must be in the year 2024",
        maxMessage: "Date must be in the year 2024"
    )]



    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'suiviReclamations')]
    private ?Reclamation $reclamation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRec(): ?int
    {
        return $this->idRec;
    }

    public function setIdRec(int $idRec): static
    {
        $this->idRec = $idRec;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): static
    {
        $this->reclamation = $reclamation;

        return $this;
    }
}
