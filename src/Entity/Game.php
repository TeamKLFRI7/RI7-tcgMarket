<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\Api\CreateCardSell;
use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'game:series:get'],
        ),
        new GetCollection(
            normalizationContext: ['groups' => 'game:collection:get'],
        ),
        new GetCollection(
            uriTemplate: '/sell',
            controller: CreateCardSell::class,
            normalizationContext: ['groups' => 'game:collection:sell'],
            name: 'sell'
        )
    ]
)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'game:series:get',
        'game:collection:get',
        'game:collection:sell'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    #[Groups([
        'game:series:get',
        'game:collection:get',
        'game:collection:sell'
    ])]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'fkIdGame', targetEntity: CardSerie::class)]
    #[Groups([
        'game:series:get',
        'game:collection:sell'
    ])]
    private Collection $cardSeries;

    #[ORM\OneToMany(mappedBy: 'fkIdGame', targetEntity: CardUser::class)]
    private Collection $cardUsers;

    #[ORM\Column]
    #[Groups([
        'game:collection:get'
    ])]
    private ?bool $isActive = null;

    public function __construct()
    {
        $this->cardSeries = new ArrayCollection();
        $this->cardUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, CardSerie>
     */
    public function getCardSeries(): Collection
    {
        return $this->cardSeries;
    }

    public function addCardSeries(CardSerie $cardSeries): self
    {
        if (!$this->cardSeries->contains($cardSeries)) {
            $this->cardSeries->add($cardSeries);
            $cardSeries->setFkIdGame($this);
        }

        return $this;
    }

    public function removeCardSeries(CardSerie $cardSeries): self
    {
        if ($this->cardSeries->removeElement($cardSeries)) {
            // set the owning side to null (unless already changed)
            if ($cardSeries->getFkIdGame() === $this) {
                $cardSeries->setFkIdGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CardUser>
     */
    public function getCardUsers(): Collection
    {
        return $this->cardUsers;
    }

    public function addCardUser(CardUser $cardUser): self
    {
        if (!$this->cardUsers->contains($cardUser)) {
            $this->cardUsers->add($cardUser);
            $cardUser->setFkIdGame($this);
        }

        return $this;
    }

    public function removeCardUser(CardUser $cardUser): self
    {
        if ($this->cardUsers->removeElement($cardUser)) {
            // set the owning side to null (unless already changed)
            if ($cardUser->getFkIdGame() === $this) {
                $cardUser->setFkIdGame(null);
            }
        }

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
