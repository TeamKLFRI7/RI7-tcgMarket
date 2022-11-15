<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
#[ApiResource]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Command $fk_id_command = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CardUser $fk_id_card = null;

    #[ORM\Column]
    private ?float $quantity = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $creatad_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkIdCommand(): ?Command
    {
        return $this->fk_id_command;
    }

    public function setFkIdCommand(?Command $fk_id_command): self
    {
        $this->fk_id_command = $fk_id_command;

        return $this;
    }

    public function getFkIdCard(): ?CardUser
    {
        return $this->fk_id_card;
    }

    public function setFkIdCard(?CardUser $fk_id_card): self
    {
        $this->fk_id_card = $fk_id_card;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getCreatadAt(): ?\DateTimeImmutable
    {
        return $this->creatad_at;
    }

    public function setCreatadAt(\DateTimeImmutable $creatad_at): self
    {
        $this->creatad_at = $creatad_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
