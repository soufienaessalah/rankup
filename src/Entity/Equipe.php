<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // #[ORM\Column]
    // private ?int $IdEquipe = null;

    // #[ORM\Column]
    // private ?int $Nbmax = null;

    #[ORM\Column(length: 20)]
    private ?string $NomEquipe = null;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: User::class)]
    private Collection $players;

    #[ORM\ManyToOne(inversedBy: 'equipes')]
    private ?MatchEntity $matchEntity = null;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getIdEquipe(): ?int
    // {
    //     return $this->IdEquipe;
    // }

    // public function setIdEquipe(int $IdEquipe): static
    // {
    //     $this->IdEquipe = $IdEquipe;

    //     return $this;
    // }

    // public function getNbmax(): ?int
    // {
    //     return $this->Nbmax;
    // }

    // public function setNbmax(int $Nbmax): static
    // {
    //     $this->Nbmax = $Nbmax;

    //     return $this;
    // }

    public function getNomEquipe(): ?string
    {
        return $this->NomEquipe;
    }

    public function setNomEquipe(string $NomEquipe): static
    {
        $this->NomEquipe = $NomEquipe;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(User $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setEquipe($this);
        }

        return $this;
    }

    public function removePlayer(User $player): static
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getEquipe() === $this) {
                $player->setEquipe(null);
            }
        }

        return $this;
    }

    public function getMatchEntity(): ?MatchEntity
    {
        return $this->matchEntity;
    }

    public function setMatchEntity(?MatchEntity $matchEntity): static
    {
        $this->matchEntity = $matchEntity;

        return $this;
    }
}
