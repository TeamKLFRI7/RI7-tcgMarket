<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'user:item:get']
        ),
        new Post(
            denormalizationContext: ['groups' => 'user:item:post'],
        ),
        new Put(
            denormalizationContext: ['groups' => 'user:item:put']
        ),
        new Delete(
            normalizationContext: ['groups' => 'user:item:delete']
        )
    ]
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'cardUser:item:get', 
        'cardInSell:item:get', 
        'user:item:get', 
        'user:item:delete',
        
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups([
        'cardUser:item:get', 
        'cardInSell:item:get', 
        'user:item:post', 
        'user:item:get', 
        'user:item:put'
    ])]
    #[Assert\Length(min: 3, max: 16)]
    private ?string $userName = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Email]
    #[Groups([
        'user:item:post', 
        'user:item:get', 
        'user:item:put'
    ])]
    private ?string $email = null;

    #[ORM\Column(length: 15, nullable: true)]
    #[Assert\Regex('^((\+|00)33\s?|0)[67](\s?\d{2}){4}$^')]
    #[Groups([
        'user:item:post', 
        'user:item:get', 
        'user:item:put'
    ])]
    private ?string $phoneNumber = null;

    #[ORM\Column]
    #[Groups([
        'user:item:post', 
        'user:item:get'
    ])]
    private ?bool $isAdmin = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min: 8, max: 50)]
    #[Groups([
        'user:item:post', 
        'user:item:put'
    ])]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToOne(mappedBy: 'fkIdUser', cascade: ['persist', 'remove'])]
    private ?UserInfo $userInfo = null;

    #[ORM\OneToMany(mappedBy: 'fkIdUser', targetEntity: Command::class)]
    private Collection $commands;

    #[ORM\OneToMany(mappedBy: 'fkIdUser', targetEntity: CardUser::class)]
    private Collection $cardUsers;

    public function __construct()
    {
        $this->commands = new ArrayCollection();
        $this->cardUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function isIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getUserInfo(): ?UserInfo
    {
        return $this->userInfo;
    }

    public function setUserInfo(UserInfo $userInfo): self
    {
        // set the owning side of the relation if necessary
        if ($userInfo->getFkIdUser() !== $this) {
            $userInfo->setFkIdUser($this);
        }

        $this->userInfo = $userInfo;

        return $this;
    }

    /**
     * @return Collection<int, Command>
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    public function addCommand(Command $command): self
    {
        if (!$this->commands->contains($command)) {
            $this->commands->add($command);
            $command->setFkIdUser($this);
        }

        return $this;
    }

    public function removeCommand(Command $command): self
    {
        if ($this->commands->removeElement($command)) {
            // set the owning side to null (unless already changed)
            if ($command->getFkIdUser() === $this) {
                $command->setFkIdUser(null);
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
            $cardUser->setFkIdUser($this);
        }

        return $this;
    }

    public function removeCardUser(CardUser $cardUser): self
    {
        if ($this->cardUsers->removeElement($cardUser)) {
            // set the owning side to null (unless already changed)
            if ($cardUser->getFkIdUser() === $this) {
                $cardUser->setFkIdUser(null);
            }
        }

        return $this;
    }
}
