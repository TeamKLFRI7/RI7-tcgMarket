<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GamesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GamesRepository::class)]
#[ApiResource]
class Games
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $names = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: 'games', targetEntity: CardSerie::class)]
    private Collection $updated_at;

    public function __construct()
    {
        $this->updated_at = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNames(): ?string
    {
        return $this->names;
    }

    public function setNames(string $names): self
    {
        $this->names = $names;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, CardSerie>
     */
    public function getUpdatedAt(): Collection
    {
        return $this->updated_at;
    }

    public function addUpdatedAt(CardSerie $updatedAt): self
    {
        if (!$this->updated_at->contains($updatedAt)) {
            $this->updated_at->add($updatedAt);
            $updatedAt->setGames($this);
        }

        return $this;
    }

    public function removeUpdatedAt(CardSerie $updatedAt): self
    {
        if ($this->updated_at->removeElement($updatedAt)) {
            // set the owning side to null (unless already changed)
            if ($updatedAt->getGames() === $this) {
                $updatedAt->setGames(null);
            }
        }

        return $this;
    }
}
