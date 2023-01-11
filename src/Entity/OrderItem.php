<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderItemRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;
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
    private ?Command $fkIdCommand = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CardUser $fkIdCardUser = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount = null;

    use TimestampableEntity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkIdCommand(): ?Command
    {
        return $this->fkIdCommand;
    }

    public function setFkIdCommand(?Command $fkIdCommand): self
    {
        $this->fkIdCommand = $fkIdCommand;

        return $this;
    }

    public function getFkIdCardUser(): ?CardUser
    {
        return $this->fkIdCardUser;
    }

    public function setFkIdCardUser(?CardUser $fkIdCardUser): self
    {
        $this->fkIdCardUser = $fkIdCardUser;

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
}
