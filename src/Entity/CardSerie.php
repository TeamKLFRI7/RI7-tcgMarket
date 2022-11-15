<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CardSerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardSerieRepository::class)]
#[ApiResource]
class CardSerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'cardSerie', targetEntity: CardSet::class)]
    private Collection $fk_id_card_set;

    #[ORM\Column(length: 45)]
    private ?string $serie_name = null;

    #[ORM\Column(length: 255)]
    private ?string $serie_link = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $serie_img = null;

    #[ORM\ManyToOne(inversedBy: 'updated_at')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Games $games = null;

    public function __construct()
    {
        $this->fk_id_card_set = new ArrayCollection();
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
        return $this->fk_id_card_set;
    }

    public function addFkIdCardSet(CardSet $fkIdCardSet): self
    {
        if (!$this->fk_id_card_set->contains($fkIdCardSet)) {
            $this->fk_id_card_set->add($fkIdCardSet);
            $fkIdCardSet->setCardSerie($this);
        }

        return $this;
    }

    public function removeFkIdCardSet(CardSet $fkIdCardSet): self
    {
        if ($this->fk_id_card_set->removeElement($fkIdCardSet)) {
            // set the owning side to null (unless already changed)
            if ($fkIdCardSet->getCardSerie() === $this) {
                $fkIdCardSet->setCardSerie(null);
            }
        }

        return $this;
    }

    public function getSerieName(): ?string
    {
        return $this->serie_name;
    }

    public function setSerieName(string $serie_name): self
    {
        $this->serie_name = $serie_name;

        return $this;
    }

    public function getSerieLink(): ?string
    {
        return $this->serie_link;
    }

    public function setSerieLink(string $serie_link): self
    {
        $this->serie_link = $serie_link;

        return $this;
    }

    public function getSerieImg(): ?string
    {
        return $this->serie_img;
    }

    public function setSerieImg(?string $serie_img): self
    {
        $this->serie_img = $serie_img;

        return $this;
    }

    public function getGames(): ?Games
    {
        return $this->games;
    }

    public function setGames(?Games $games): self
    {
        $this->games = $games;

        return $this;
    }
}
