<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Broadcast]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $cat_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\ManyToOne(inversedBy: 'products_disc')]
    private ?Discount $discount_id = null;

    #[ORM\OneToOne(mappedBy: 'prod_id', cascade: ['persist', 'remove'])]
    private ?Inventory $inventoryy = null;

    #[ORM\ManyToOne(inversedBy: 'prod_id')]
    private ?Orders $orders = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getCatId(): ?Category
    {
        return $this->cat_id;
    }

    public function setCatId(?Category $cat_id): static
    {
        $this->cat_id = $cat_id;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscountId(): ?Discount
    {
        return $this->discount_id;
    }

    public function setDiscountId(?Discount $discount_id): static
    {
        $this->discount_id = $discount_id;

        return $this;
    }

    public function getInventoryy(): ?Inventory
    {
        return $this->inventoryy;
    }

    public function setInventoryy(?Inventory $inventoryy): static
    {
        // unset the owning side of the relation if necessary
        if ($inventoryy === null && $this->inventoryy !== null) {
            $this->inventoryy->setProdId(null);
        }

        // set the owning side of the relation if necessary
        if ($inventoryy !== null && $inventoryy->getProdId() !== $this) {
            $inventoryy->setProdId($this);
        }

        $this->inventoryy = $inventoryy;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): static
    {
        $this->orders = $orders;

        return $this;
    }
}
