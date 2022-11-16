<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CardSetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CardSetRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'set:item:get'],
        )
    ]
)]
class CardSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["series:collection:get", "set:item:get"])]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'cardSet', targetEntity: CardUser::class)]
    #[Groups(["set:item:get"])]
    private Collection $fk_id_card;

    #[ORM\OneToMany(mappedBy: 'cardSet', targetEntity: CataCard::class)]
    #[Groups(["set:item:get"])]
    private Collection $fk_id_cata_card;

    #[ORM\Column(length: 45)]
    #[Groups(["series:collection:get"])]
    private ?string $api_set_id = null;

    #[ORM\Column(length: 45)]
    #[Groups(["series:collection:get", "set:item:get"])]
    private ?string $set_name = null;

    #[ORM\Column(length: 45)]
    #[Groups(["series:collection:get"])]
    private ?string $set_link = null;

    #[ORM\Column(length: 45)]
    #[Groups(["series:collection:get"])]
    private ?string $set_img = null;

    #[ORM\ManyToOne(inversedBy: 'fk_id_card_set')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CardSerie $cardSerie = null;

    public function __construct()
    {
        $this->fk_id_card = new ArrayCollection();
        $this->fk_id_cata_card = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $fkIdCard->setCardSet($this);
        }

        return $this;
    }

    public function removeFkIdCard(CardUser $fkIdCard): self
    {
        if ($this->fk_id_card->removeElement($fkIdCard)) {
            // set the owning side to null (unless already changed)
            if ($fkIdCard->getCardSet() === $this) {
                $fkIdCard->setCardSet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CataCard>
     */
    public function getFkIdCataCard(): Collection
    {
        return $this->fk_id_cata_card;
    }

    public function addFkIdCataCard(CataCard $fkIdCataCard): self
    {
        if (!$this->fk_id_cata_card->contains($fkIdCataCard)) {
            $this->fk_id_cata_card->add($fkIdCataCard);
            $fkIdCataCard->setCardSet($this);
        }

        return $this;
    }

    public function removeFkIdCataCard(CataCard $fkIdCataCard): self
    {
        if ($this->fk_id_cata_card->removeElement($fkIdCataCard)) {
            // set the owning side to null (unless already changed)
            if ($fkIdCataCard->getCardSet() === $this) {
                $fkIdCataCard->setCardSet(null);
            }
        }

        return $this;
    }

    public function getApiSetId(): ?string
    {
        return $this->api_set_id;
    }

    public function setApiSetId(string $api_set_id): self
    {
        $this->api_set_id = $api_set_id;

        return $this;
    }

    public function getSetName(): ?string
    {
        return $this->set_name;
    }

    public function setSetName(string $set_name): self
    {
        $this->set_name = $set_name;

        return $this;
    }

    public function getSetLink(): ?string
    {
        return $this->set_link;
    }

    public function setSetLink(string $set_link): self
    {
        $this->set_link = $set_link;

        return $this;
    }

    public function getSetImg(): ?string
    {
        return $this->set_img;
    }

    public function setSetImg(string $set_img): self
    {
        $this->set_img = $set_img;

        return $this;
    }

    public function getCardSerie(): ?CardSerie
    {
        return $this->cardSerie;
    }

    public function setCardSerie(?CardSerie $cardSerie): self
    {
        $this->cardSerie = $cardSerie;

        return $this;
    }
}
