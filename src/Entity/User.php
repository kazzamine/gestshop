<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[Broadcast]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $first_name = null;

    #[ORM\Column(length: 100)]
    private ?string $last_name = null;

    #[ORM\Column]
    private ?int $telephone = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $modified_at = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: UserAdress::class)]
    private Collection $userAdresses;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: ShoppingSession::class)]
    private Collection $shoppingSessions;

    #[ORM\OneToOne(mappedBy: 'user_id', cascade: ['persist', 'remove'])]
    private ?Cart $cart = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Orders::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->userAdresses = new ArrayCollection();
        $this->shoppingSessions = new ArrayCollection();
        $this->orders = new ArrayCollection();
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

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(\DateTimeInterface $modified_at): static
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    /**
     * @return Collection<int, UserAdress>
     */
    public function getUserAdresses(): Collection
    {
        return $this->userAdresses;
    }

    public function addUserAdress(UserAdress $userAdress): static
    {
        if (!$this->userAdresses->contains($userAdress)) {
            $this->userAdresses->add($userAdress);
            $userAdress->setUserId($this);
        }

        return $this;
    }

    public function removeUserAdress(UserAdress $userAdress): static
    {
        if ($this->userAdresses->removeElement($userAdress)) {
            // set the owning side to null (unless already changed)
            if ($userAdress->getUserId() === $this) {
                $userAdress->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ShoppingSession>
     */
    public function getShoppingSessions(): Collection
    {
        return $this->shoppingSessions;
    }

    public function addShoppingSession(ShoppingSession $shoppingSession): static
    {
        if (!$this->shoppingSessions->contains($shoppingSession)) {
            $this->shoppingSessions->add($shoppingSession);
            $shoppingSession->setUserId($this);
        }

        return $this;
    }

    public function removeShoppingSession(ShoppingSession $shoppingSession): static
    {
        if ($this->shoppingSessions->removeElement($shoppingSession)) {
            // set the owning side to null (unless already changed)
            if ($shoppingSession->getUserId() === $this) {
                $shoppingSession->setUserId(null);
            }
        }

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): static
    {
        // unset the owning side of the relation if necessary
        if ($cart === null && $this->cart !== null) {
            $this->cart->setUserId(null);
        }

        // set the owning side of the relation if necessary
        if ($cart !== null && $cart->getUserId() !== $this) {
            $cart->setUserId($this);
        }

        $this->cart = $cart;

        return $this;
    }

    /**
     * @return Collection<int, Orders>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUserId($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUserId() === $this) {
                $order->setUserId(null);
            }
        }

        return $this;
    }

    #[ORM\Column(type: Types::JSON)]
    private $roles = [];

    /**
     * Set the roles for the user.
     *
     * @param array $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

     
     /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        // Ensure that the user always has at least one role
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password; // Assuming you have a property named 'password'
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        // You might need this if you're not using a modern password hashing algorithm
        return null;
    }

    /**
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->username; // Assuming you have a property named 'username'
    }
 /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->username; // Assuming you have a property named 'username'
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials():void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // For example, $this->plainPassword = null;
    }
}
