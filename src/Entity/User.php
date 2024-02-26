<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['username'], message: 'This username is already taken')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Please enter an email')]
    #[Assert\Email(message: 'The email "{{ value }}" is not a valid email.')]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z]+$/i",
        message: 'Your first name can only contain letters'
    )]
    private ?string $firstname = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z]+$/i",
        message: 'Your last name can only contain letters'
    )]
    private ?string $lastname = null;


    #[ORM\Column(nullable: true)]
    private ?string $resetToken = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Please enter a username')]
    #[Assert\Length(
        min: 4,
        max: 50,
        minMessage: 'Your username must be at least {{ limit }} characters long',
        maxMessage: 'Your username cannot be longer than {{ limit }} characters'
    )]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: '/^\d{8}$/',
        message: 'Your phone number must contain exactly 8 numbers'
    )]
    private ?string $phone = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(nullable: true)]
    private ?string $whyBlocked = null;

    #[ORM\Column(nullable: true)]
    private string $status = 'active'; // Initialized to 'active' by default 

    #[ORM\Column(type:"json", nullable:true)]
    private ?array $elo = null;

    #[ORM\Column(nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(
        max: 15,
        maxMessage: 'Your summoner name cannot be longer than {{ limit }} characters'
    )]
    private ?string $summonername = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getWhyBlocked(): ?string
    {
        return $this->whyBlocked;
    }

    public function setWhyBlocked(?string $whyBlocked): static
    {
        $this->whyBlocked = $whyBlocked;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }
    public function getElo(): ?array
    {
        return $this->elo;
    }

    public function setElo(?array $elo): static
    {
        $this->elo = $elo;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getSummonername(): ?string
    {
        return $this->summonername;
    }

    public function setSummonername(?string $summonername): static
    {
        $this->summonername = $summonername;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }
    

    /**
     * Get the value of resetToken
     */ 
    public function getResetToken()
    {
        return $this->resetToken;
    }

    /**
     * Set the value of resetToken
     *
     * @return  self
     */ 
    public function setResetToken($resetToken)
    {
        $this->resetToken = $resetToken;

        return $this;
    }
}