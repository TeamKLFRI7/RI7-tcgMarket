<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use App\Repository\CardUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CardUserRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'cardUser:item:get'],
        ),
        new GetCollection(
            normalizationContext: ['groups' => 'cardUser:collection:get']
        ),
        new Put(
            denormalizationContext:['groups' => 'cardUser:item:put']
        ),
        new Delete(
            normalizationContext:['groups' => 'cardUser:item:delete']
        )
    ],
)]
class CardUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'cardSet:item:get', 
        'cardUser:item:get', 
        'cardInSell:item:get',
        'cardUser:collection:get',
        'cardUser:item:delete'
    ])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cardUsers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'cardUser:item:get', 
        'cardInSell:item:get',
        'cardUser:collection:get',
        'cardUser:item:put'
    ])]
    private ?User $fkIdUser = null;

    #[ORM\Column(length: 100)]
    #[Groups([
        'cardInSell:item:get',
        'cardUser:collection:get',
        'cardUser:item:post',
        'cardUser:item:put',
        'cardUser:item:get'
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 45)]
    #[Groups([
        'cardInSell:item:get',
        'cardUser:collection:get',
        'cardUser:item:post',
        'cardUser:item:put',
        'cardUser:item:get'
    ])]
    private ?string $quality = null;

    #[ORM\Column]
    #[Groups([
        'cardInSell:item:get',
        'cardUser:collection:get',
        'cardUser:item:post',
        'cardUser:item:put',
        'cardUser:item:get'
    ])]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'fkIdCardUser', targetEntity: OrderItem::class)]
    private Collection $orderItems;

    #[ORM\ManyToOne(inversedBy: 'fkIdCardUser')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'cardUser:item:put',
        'cardSet:item:get'
    ])]
    private ?Card $card = null;

    #[ORM\ManyToOne(inversedBy: 'fkIdCardUser')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['cardUser:item:put'])]
    private ?CardSet $cardSet = null;

    #[Groups([
        'cardInSell:item:get',
        'cardUser:item:get'
    ])]
    public ?string $fileUrl = null;

    #[Vich\UploadableField(mapping: "images_upload", fileNameProperty: "fileName")]
    private ?File $file = null;

    #[ORM\Column(nullable: false)]
    public ?string $fileName = null;

    #[ORM\ManyToOne(inversedBy: 'cardUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $fkIdGame = null;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkIdUser(): ?User
    {
        return $this->fkIdUser;
    }

    public function setFkIdUser(?User $fkIdUser): self
    {
        $this->fkIdUser = $fkIdUser;

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

    public function getQuality(): ?string
    {
        return $this->quality;
    }

    public function setQuality(string $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setFkIdCardUser($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getFkIdCardUser() === $this) {
                $orderItem->setFkIdCardUser(null);
            }
        }

        return $this;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): self
    {
        $this->card = $card;

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

    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    public function setFileUrl(?string $fileUrl): self
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

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
}
