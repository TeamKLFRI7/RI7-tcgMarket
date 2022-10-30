<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CardUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardUserRepository::class)]
#[ApiResource]
class CardUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cardUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fk_id_user = null;

    #[ORM\Column(length: 45)]
    private ?string $name = null;

    #[ORM\Column(length: 45)]
    private ?string $quality = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 45)]
    private ?string $img = null;

    #[ORM\OneToMany(mappedBy: 'fk_id_card', targetEntity: OrderItem::class)]
    private Collection $orderItems;

    #[ORM\OneToMany(mappedBy: 'fk_id_card', targetEntity: CataCard::class)]
    private Collection $cataCards;

    #[ORM\ManyToOne(inversedBy: 'fk_id_card')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CardSet $cardSet = null;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->cataCards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkIdUser(): ?User
    {
        return $this->fk_id_user;
    }

    public function setFkIdUser(?User $fk_id_user): self
    {
        $this->fk_id_user = $fk_id_user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQuality(): ?string
    {
        return $this->quality;
    }

    public function setQuality(string $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setFkIdCard($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getFkIdCard() === $this) {
                $orderItem->setFkIdCard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CataCard>
     */
    public function getCataCards(): Collection
    {
        return $this->cataCards;
    }

    public function addCataCard(CataCard $cataCard): self
    {
        if (!$this->cataCards->contains($cataCard)) {
            $this->cataCards->add($cataCard);
            $cataCard->setFkIdCard($this);
        }

        return $this;
    }

    public function removeCataCard(CataCard $cataCard): self
    {
        if ($this->cataCards->removeElement($cataCard)) {
            // set the owning side to null (unless already changed)
            if ($cataCard->getFkIdCard() === $this) {
                $cataCard->setFkIdCard(null);
            }
        }

        return $this;
    }

    public function getCardSet(): ?CardSet
    {
        return $this->cardSet;
    }

    public function setCardSet(?CardSet $cardSet): self
    {
        $this->cardSet = $cardSet;

        return $this;
    }
}
