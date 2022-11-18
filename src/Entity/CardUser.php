<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\CardUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CardUserRepository::class)]
#[ApiResource]
class CardUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["set:item:get", "cardSell:item:get"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cardUsers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["cardSell:item:get"])]
    private ?User $fk_id_user = null;

    #[ORM\Column(length: 45)]
    #[Groups(["cardSell:item:get"])]
    private ?string $name = null;

    #[ORM\Column(length: 45)]
    #[Groups(["cardSell:item:get"])]
    private ?string $quality = null;

    #[ORM\Column]
    #[Groups(["cardSell:item:get"])]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(["cardSell:item:get"])]
    private ?float $price = null;

    #[ORM\Column(length: 45)]
    #[Groups(["cardSell:item:get"])]
    private ?string $img = null;

    #[ORM\OneToMany(mappedBy: 'fk_id_card', targetEntity: OrderItem::class)]
    private Collection $orderItems;

    #[ORM\ManyToOne(inversedBy: 'fk_id_card')]
    private ?CataCard $cataCard;

    #[ORM\ManyToOne(inversedBy: 'fk_id_card')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CardSet $cardSet = null;


    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
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

    public function getCardSet(): ?CardSet
    {
        return $this->cardSet;
    }

    public function setCardSet(?CardSet $cardSet): self
    {
        $this->cardSet = $cardSet;

        return $this;
    }

    public function getCataCard(): ?CataCard
    {
        return $this->cataCard;
    }

    public function setCataCard(?Catacard $cataCard): self
    {
        $this->cataCard = $cataCard;

        return $this;
    }
}
