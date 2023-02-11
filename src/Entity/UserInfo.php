<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;

use App\Repository\UserInfoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserInfoRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'userInfos:item:get']
        ),
        new GetCollection(
            normalizationContext: ['groups' => 'userInfos:collection:get']
        ),
        new Post(
            denormalizationContext: ['groups' => 'userInfos:item:post'],
        ),
        new Put(
            denormalizationContext: ['groups' => 'userInfos:item:put']
        ),
        new Delete(
            normalizationContext: ['groups' => 'userInfos:item:delete']
        )
    ]
)]
class UserInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'user:item:get',
        'user:item:put',
        'userInfos:item:get',
        'userInfos:collection:get',
        'userInfos:item:post',
        'userInfos:item:put',
        'userInfos:item:delete'
    ])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'userInfo', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([

        'userInfos:item:get',
        'userInfos:collection:get',
        'userInfos:item:post',
        'userInfos:item:put',
    ])]
    private ?User $fkIdUser = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(max: 45)]
    #[Groups([
        'user:item:get',
        'user:item:put',
        'userInfos:item:get',
        'userInfos:collection:get',
        'userInfos:item:post',
        'userInfos:item:put'
    ])]
    private ?string $city = null;

    #[ORM\Column(length: 45, nullable: true)]
    #[Groups([
        'user:item:get',
        'user:item:put',
        'userInfos:item:get',
        'userInfos:collection:get',
        'userInfos:item:post',
        'userInfos:item:put'
    ])]
    private ?string $country = null;

    #[ORM\Column(length: 55, nullable: true)]
    #[Assert\Length(min: 7, max: 30)]
    #[Groups([
        'user:item:get',
        'user:item:put',
        'userInfos:item:get',
        'userInfos:collection:get',
        'userInfos:item:post',
        'userInfos:item:put'
    ])]
    private ?string $address = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Assert\Regex('/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/')]
    #[Groups([
        'user:item:get',
        'user:item:put',
        'userInfos:item:get',
        'userInfos:collection:get',
        'userInfos:item:post',
        'userInfos:item:put'
    ])]
    private ?string $postalCode = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
        'user:item:get',
        'user:item:put',
        'userInfos:item:get',
        'userInfos:collection:get',
        'userInfos:item:post',
        'userInfos:item:put'
    ])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'user:item:get',
        'user:item:put',
        'userInfos:item:get',
        'userInfos:collection:get',
        'userInfos:item:post',
        'userInfos:item:put'
    ])]
    private ?string $deliveryAddress = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkIdUser(): ?User
    {
        return $this->fkIdUser;
    }

    public function setFkIdUser(User $fkIdUser): self
    {
        $this->fkIdUser = $fkIdUser;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?string $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }
}
