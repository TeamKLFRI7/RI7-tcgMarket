<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 16)]
    private ?string $username = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?bool $is_admin = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $create_time = null;

    #[ORM\OneToOne(mappedBy: 'fk_user_id', cascade: ['persist', 'remove'])]
    private ?UserInfo $userInfo = null;

    #[ORM\OneToMany(mappedBy: 'fk_id_user', targetEntity: Command::class)]
    private Collection $commands;

    #[ORM\OneToMany(mappedBy: 'fk_id_user', targetEntity: CardUser::class)]
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function isIsAdmin(): ?bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(bool $is_admin): self
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    public function getCreateTime(): ?\DateTimeInterface
    {
        return $this->create_time;
    }

    public function setCreateTime(\DateTimeInterface $create_time): self
    {
        $this->create_time = $create_time;

        return $this;
    }

    public function getUserInfo(): ?UserInfo
    {
        return $this->userInfo;
    }

    public function setUserInfo(UserInfo $userInfo): self
    {
        // set the owning side of the relation if necessary
        if ($userInfo->getFkUserId() !== $this) {
            $userInfo->setFkUserId($this);
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
