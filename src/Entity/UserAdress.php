<?php

namespace App\Entity;

use App\Repository\UserAdressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: UserAdressRepository::class)]
#[Broadcast]
class UserAdress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userAdresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_line1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adress_line2 = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 100)]
    private ?string $postal_code = null;

    #[ORM\Column(length: 150)]
    private ?string $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getAdresseLine1(): ?string
    {
        return $this->adresse_line1;
    }

    public function setAdresseLine1(string $adresse_line1): static
    {
        $this->adresse_line1 = $adresse_line1;

        return $this;
    }

    public function getAdressLine2(): ?string
    {
        return $this->adress_line2;
    }

    public function setAdressLine2(?string $adress_line2): static
    {
        $this->adress_line2 = $adress_line2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): static
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }
}
