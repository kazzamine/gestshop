<?php

namespace App\Entity;

use App\Repository\DiscountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: DiscountRepository::class)]
#[Broadcast]
class Discount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $discount_perc = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'discount_id', targetEntity: Product::class)]
    private Collection $products_disc;

    public function __construct()
    {
        $this->products_disc = new ArrayCollection();
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDiscountPerc(): ?string
    {
        return $this->discount_perc;
    }

    public function setDiscountPerc(string $discount_perc): static
    {
        $this->discount_perc = $discount_perc;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductsDisc(): Collection
    {
        return $this->products_disc;
    }

    public function addProductsDisc(Product $productsDisc): static
    {
        if (!$this->products_disc->contains($productsDisc)) {
            $this->products_disc->add($productsDisc);
            $productsDisc->setDiscountId($this);
        }

        return $this;
    }

    public function removeProductsDisc(Product $productsDisc): static
    {
        if ($this->products_disc->removeElement($productsDisc)) {
            // set the owning side to null (unless already changed)
            if ($productsDisc->getDiscountId() === $this) {
                $productsDisc->setDiscountId(null);
            }
        }

        return $this;
    }
}
