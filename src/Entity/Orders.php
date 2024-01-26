<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
#[Broadcast]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user_id = null;

    #[ORM\OneToMany(mappedBy: 'orders', targetEntity: Product::class)]
    private Collection $prod_id;

    public function __construct()
    {
        $this->prod_id = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Product>
     */
    public function getProdId(): Collection
    {
        return $this->prod_id;
    }

    public function addProdId(Product $prodId): static
    {
        if (!$this->prod_id->contains($prodId)) {
            $this->prod_id->add($prodId);
            $prodId->setOrders($this);
        }

        return $this;
    }

    public function removeProdId(Product $prodId): static
    {
        if ($this->prod_id->removeElement($prodId)) {
            // set the owning side to null (unless already changed)
            if ($prodId->getOrders() === $this) {
                $prodId->setOrders(null);
            }
        }

        return $this;
    }
}
