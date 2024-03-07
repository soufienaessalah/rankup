<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\SuiviReclamation;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"type is required")]
    #[Assert\Length(  min : 2,
         max :6,
        minMessage :"type must be at least {{ limit }} characters long",
        maxMessage : "type cannot be longer than {{ limit }} characters")]
    #[Assert\Choice(
            choices: ["coachs", "game", "site", "leçon"],
            message: "Invalid type. Allowed types are coachs, game, site, leçon"
        )]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"description is required")]
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

    #[ORM\OneToMany(mappedBy: 'reclamation', targetEntity: SuiviReclamation::class)]
    private Collection $suiviReclamations;

    
    public function __construct()
    {
        $this->suiviReclamations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    /**
     * @return Collection<int, SuiviReclamation>
     */
    public function getSuiviReclamations(): Collection
    {
        return $this->suiviReclamations;
    }

    public function addSuiviReclamation(SuiviReclamation $suiviReclamation): static
    {
        if (!$this->suiviReclamations->contains($suiviReclamation)) {
            $this->suiviReclamations->add($suiviReclamation);
            $suiviReclamation->setReclamation($this);
        }

        return $this;
    }

    public function removeSuiviReclamation(SuiviReclamation $suiviReclamation): static
    {
        if ($this->suiviReclamations->removeElement($suiviReclamation)) {
            // set the owning side to null (unless already changed)
            if ($suiviReclamation->getReclamation() === $this) {
                $suiviReclamation->setReclamation(null);
            }
        }

        return $this;
    }

    

   
}
