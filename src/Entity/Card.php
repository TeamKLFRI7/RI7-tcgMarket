<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CardRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'cardInSell:item:get'],
        )
    ]
)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'cardSet:item:get', 
        'cardSet:collection:get', 
        'cardInSell:item:get',
        'cardSet:item:get',
        'cardInSell:item:get',
        'game:collection:sell'
    ])]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'card', targetEntity: CardUser::class)]
    #[Groups([
        'cardSet:item:get', 
        'cardSet:collection:get', 
        'cardInSell:item:get'
    ])]
    private Collection $fkIdCardUser;

    #[ORM\Column(length: 100)]
    private ?string $apiCardId = null;

    #[ORM\Column(length: 100)]
    #[Groups([
        'cardSet:item:get', 
        'cardSet:collection:get', 
        'cardInSell:item:get',
        'game:collection:sell'
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'cardSet:item:get', 
        'cardSet:collection:get',
        'game:collection:sell'
    ])]
    private ?string $img = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\ManyToOne(inversedBy: 'fkIdCar')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CardSet $cardSet = null;

    public function __construct()
    {
        $this->fkIdCardUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, CardUser>
     */
    public function getFkIdCardUser(): Collection
    {
        return $this->fkIdCardUser;
    }

    public function addFkIdCardUser(CardUser $fkIdCardUser): self
    {
        if (!$this->fkIdCardUser->contains($fkIdCardUser)) {
            $this->fkIdCardUser->add($fkIdCardUser);
            $fkIdCardUser->setCard($this);
        }

        return $this;
    }

    public function removeFkIdCardUser(CardUser $fkIdCardUser): self
    {
        if ($this->fkIdCardUser->removeElement($fkIdCardUser)) {
            // set the owning side to null (unless already changed)
            if ($fkIdCardUser->getCard() === $this) {
                $fkIdCardUser->setCard(null);
            }
        }

        return $this;
    }

    public function getApiCardId(): ?string
    {
        return $this->apiCardId;
    }

    public function setApiCardId(string $apiCardId): self
    {
        $this->apiCardId = $apiCardId;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

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
