<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomSponsor = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseSponsor = null;

    #[ORM\Column(length: 255)]
    private ?string $mailSponsor = null;

   

    
    
   
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSponsor(): ?string
    {
        return $this->nomSponsor;
    }

    public function setNomSponsor(string $nomSponsor): static
    {
        $this->nomSponsor = $nomSponsor;

        return $this;
    }

    public function getAdresseSponsor(): ?string
    {
        return $this->adresseSponsor;
    }

    public function setAdresseSponsor(string $adresseSponsor): static
    {
        $this->adresseSponsor = $adresseSponsor;

        return $this;
    }

    public function getMailSponsor(): ?string
    {
        return $this->mailSponsor;
    }

    public function setMailSponsor(string $mailSponsor): static
    {
        $this->mailSponsor = $mailSponsor;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */

   

}
