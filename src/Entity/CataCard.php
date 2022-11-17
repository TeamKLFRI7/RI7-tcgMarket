<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\CataCardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CataCardRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'cardSell:item:get'],
        )
    ]
)]
class CataCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $api_card_id = null;

    #[ORM\Column(length: 45)]
    #[Groups(["cardSell:item:get", "set:item:get"])]
    private ?string $name = null;

    #[ORM\Column(length: 45)]
    #[Groups(["set:item:get"])]
    private ?string $img = null;

    #[ORM\Column(length: 45)]
    private ?string $cata_card_link = null;

    #[ORM\ManyToOne(inversedBy: 'fk_id_cata_card')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CardSet $cardSet = null;

    #[ORM\OneToMany(mappedBy: 'cataCard', targetEntity: CardUser::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["set:item:get", "cardSell:item:get"])]
    private Collection|null $fk_id_card;

    public function __construct()
    {
        $this->fk_id_card = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, CardUser>
     */
    public function getFkIdCard(): Collection
    {
        return $this->fk_id_card;
    }

    public function addFkIdCard(CardUser $fkIdCard): self
    {
        if (!$this->fk_id_card->contains($fkIdCard)) {
            $this->fk_id_card->add($fkIdCard);
            $fkIdCard->setCataCard($this);
        }

        return $this;
    }

    public function removeFkIdCard(CardUser $fkIdCard): self
    {
        if ($this->fk_id_card->removeElement($fkIdCard)) {
            // set the owning side to null (unless already changed)
            if ($fkIdCard->getCataCard() === $this) {
                $fkIdCard->setCataCard(null);
            }
        }

        return $this;
    }
}
