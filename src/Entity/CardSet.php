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
            normalizationContext: ['groups' => 'cardSet:item:get'],
        ),
        new GetCollection(
            normalizationContext: ['groups' => 'cardSet:collection:get'],
        )
    ]
)]
class CardSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'game:series:get', 
        'cardSerie:item:get', 
        'cardSerie:collection:get', 
        'cardSet:item:get', 
        'cardSet:collection:get'
    ])]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'cardSet', targetEntity: CardUser::class)]
    private Collection $fkIdCardUser;

    #[ORM\OneToMany(mappedBy: 'cardSet', targetEntity: Card::class)]
    #[Groups(['cardSet:item:get'])]
    private Collection $fkIdCar;

    #[ORM\Column(length: 100)]
    #[Groups([
        'game:series:get', 
        'cardSerie:item:get', 
        'cardSerie:collection:get',
        'cardSet:collection:get'
    ])]
    private ?string $apiSetId = null;

    #[ORM\Column(length: 100)]
    #[Groups([
        'game:series:get', 
        'cardSerie:item:get', 
        'cardSerie:collection:get', 
        'cardSet:item:get',
        'cardSet:collection:get'
    ])]
    private ?string $setName = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'game:series:get', 
        'cardSerie:item:get', 
        'cardSerie:collection:get',
        'cardSet:collection:get'
    ])]
    private ?string $img = null;

    #[ORM\ManyToOne(inversedBy: 'fkIdCardSet')]
    private ?CardSerie $cardSerie = null;

    public function __construct()
    {
        $this->fkIdCardUser = new ArrayCollection();
        $this->fkIdCar = new ArrayCollection();
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
            $fkIdCardUser->setCardSet($this);
        }

        return $this;
    }

    public function removeFkIdCardUser(CardUser $fkIdCardUser): self
    {
        if ($this->fkIdCardUser->removeElement($fkIdCardUser)) {
            // set the owning side to null (unless already changed)
            if ($fkIdCardUser->getCardSet() === $this) {
                $fkIdCardUser->setCardSet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getFkIdCar(): Collection
    {
        return $this->fkIdCar;
    }

    public function addFkIdCar(Card $fkIdCar): self
    {
        if (!$this->fkIdCar->contains($fkIdCar)) {
            $this->fkIdCar->add($fkIdCar);
            $fkIdCar->setCardSet($this);
        }

        return $this;
    }

    public function removeFkIdCar(Card $fkIdCar): self
    {
        if ($this->fkIdCar->removeElement($fkIdCar)) {
            // set the owning side to null (unless already changed)
            if ($fkIdCar->getCardSet() === $this) {
                $fkIdCar->setCardSet(null);
            }
        }

        return $this;
    }

    public function getApiSetId(): ?string
    {
        return $this->apiSetId;
    }

    public function setApiSetId(string $apiSetId): self
    {
        $this->apiSetId = $apiSetId;

        return $this;
    }

    public function getSetName(): ?string
    {
        return $this->setName;
    }

    public function setSetName(string $setName): self
    {
        $this->setName = $setName;

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
