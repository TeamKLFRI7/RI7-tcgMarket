<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CommandRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandRepository::class)]
#[ApiResource]
class Command
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commands')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fkIdUser = null;

    #[ORM\Column(nullable: true)]
    private ?float $shipping = null;

    #[ORM\Column(nullable: true)]
    private ?float $total = null;

    #[ORM\Column(length: 45)]
    private ?string $statusCommand = null;

    #[ORM\OneToMany(mappedBy: 'fkIdCommand', targetEntity: OrderItem::class)]
    private Collection $orderItems;

    use TimestampableEntity;

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
        return $this->fkIdUser;
    }

    public function setFkIdUser(?User $fkIdUser): self
    {
        $this->fkIdUser = $fkIdUser;

        return $this;
    }

    public function getShipping(): ?float
    {
        return $this->shipping;
    }

    public function setShipping(?float $shipping): self
    {
        $this->shipping = $shipping;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getStatusCommand(): ?string
    {
        return $this->statusCommand;
    }

    public function setStatusCommand(string $statusCommand): self
    {
        $this->statusCommand = $statusCommand;

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
            $orderItem->setFkIdCommand($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getFkIdCommand() === $this) {
                $orderItem->setFkIdCommand(null);
            }
        }

        return $this;
    }
}
