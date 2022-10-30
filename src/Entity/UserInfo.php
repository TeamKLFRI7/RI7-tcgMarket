<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserInfoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserInfoRepository::class)]
#[ApiResource]
class UserInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'userInfo', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fk_user_id = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 55, nullable: true)]
    private ?string $adress = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $zip_code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $delivery_adress = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkUserId(): ?User
    {
        return $this->fk_user_id;
    }

    public function setFkUserId(User $fk_user_id): self
    {
        $this->fk_user_id = $fk_user_id;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(?string $zip_code): self
    {
        $this->zip_code = $zip_code;

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

    public function getDeliveryAdress(): ?string
    {
        return $this->delivery_adress;
    }

    public function setDeliveryAdress(?string $delivery_adress): self
    {
        $this->delivery_adress = $delivery_adress;

        return $this;
    }
}
