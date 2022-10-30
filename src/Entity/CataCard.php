<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CataCardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CataCardRepository::class)]
#[ApiResource]
class CataCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cataCards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CardUser $fk_id_card = null;

    #[ORM\Column]
    private ?int $api_card_id = null;

    #[ORM\Column(length: 45)]
    private ?string $name = null;

    #[ORM\Column(length: 45)]
    private ?string $img = null;

    #[ORM\Column(length: 45)]
    private ?string $cata_card_link = null;

    #[ORM\ManyToOne(inversedBy: 'fk_id_cata_card')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CardSet $cardSet = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getApiCardId(): ?int
    {
        return $this->api_card_id;
    }

    public function setApiCardId(int $api_card_id): self
    {
        $this->api_card_id = $api_card_id;

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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getCataCardLink(): ?string
    {
        return $this->cata_card_link;
    }

    public function setCataCardLink(string $cata_card_link): self
    {
        $this->cata_card_link = $cata_card_link;

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
