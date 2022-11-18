<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CardSerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CardSerieRepository::class)]
#[ApiResource]
class CardSerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'cardSerie', targetEntity: CardSet::class)]
    #[Groups(['game:series:get'])]
    private Collection $fkIdCardSet;

    #[ORM\ManyToOne(inversedBy: 'cardSeries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $fkIdGame = null;

    #[ORM\Column(length: 100)]
    #[Groups(['game:series:get'])]
    private ?string $serieName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['game:series:get'])]
    private ?string $img = null;

    public function __construct()
    {
        $this->fkIdCardSet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, CardSet>
     */
    public function getFkIdCardSet(): Collection
    {
        return $this->fkIdCardSet;
    }

    public function addFkIdCardSet(CardSet $fkIdCardSet): self
    {
        if (!$this->fkIdCardSet->contains($fkIdCardSet)) {
            $this->fkIdCardSet->add($fkIdCardSet);
            $fkIdCardSet->setCardSerie($this);
        }

        return $this;
    }

    public function removeFkIdCardSet(CardSet $fkIdCardSet): self
    {
        if ($this->fkIdCardSet->removeElement($fkIdCardSet)) {
            // set the owning side to null (unless already changed)
            if ($fkIdCardSet->getCardSerie() === $this) {
                $fkIdCardSet->setCardSerie(null);
            }
        }

        return $this;
    }

    public function getFkIdGame(): ?Game
    {
        return $this->fkIdGame;
    }

    public function setFkIdGame(?Game $fkIdGame): self
    {
        $this->fkIdGame = $fkIdGame;

        return $this;
    }

    public function getSerieName(): ?string
    {
        return $this->serieName;
    }

    public function setSerieName(string $serieName): self
    {
        $this->serieName = $serieName;

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
}
