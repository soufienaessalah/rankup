<?php

namespace App\Entity;

use App\Repository\LeconRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LeconRepository::class)]
class Lecon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
     
    /**
     * @Assert\NotBlank(message="Le nom de la leçon doit être non vide")
     * @Assert\Length(
     *      min = 5,
     *      minMessage="Entrer un nom au minimum de 5 caractères"
     * )
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(length: 255)]
    private ?string $nom_lecon = null;
 /**
     * @Assert\NotBlank(message="Le nom de la leçon doit être non vide")
     * @Assert\Length(
     *      min = 5,
     *      minMessage="Entrer un nom au minimum de 5 caractères"
     * )
     * @ORM\Column(type="string", length=255)
     */

    #[ORM\Column(length: 255)]
    private ?string $url = null;
    
    /**
     * @Assert\NotBlank(message="Le prix doit être non vide")
     * @Assert\Type(type="float", message="Le prix doit être un nombre décimal")
     * @Assert\Range(
     *      min = 0.0,
     *      minMessage="Le prix doit être positif ou nul"
     * )
     * @ORM\Column(type="float")
     */

    #[ORM\Column]
    private ?float $prix = null;
     /**
     * @Assert\NotBlank(message="La description doit être non vide")
     * @Assert\Length(
     *      min = 7,
     *      max = 100,
     *      minMessage="La description doit avoir au moins 7 caractères",
     *      maxMessage="La description ne doit pas dépasser 100 caractères"
     * )
     * @ORM\Column(length=1000)
     */
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'lecons')]
    private ?Categorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLecon(): ?string
    {
        return $this->nom_lecon;
    }

    public function setNomLecon(string $nom_lecon): static
    {
        $this->nom_lecon = $nom_lecon;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

}