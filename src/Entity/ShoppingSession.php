<?php

namespace App\Entity;

use App\Repository\ShoppingSessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: ShoppingSessionRepository::class)]
#[Broadcast]
class ShoppingSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'shoppingSessions')]
    private ?User $user_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $loggedin_at = null;

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

    public function getLoggedinAt(): ?\DateTimeInterface
    {
        return $this->loggedin_at;
    }

    public function setLoggedinAt(\DateTimeInterface $loggedin_at): static
    {
        $this->loggedin_at = $loggedin_at;

        return $this;
    }
}
