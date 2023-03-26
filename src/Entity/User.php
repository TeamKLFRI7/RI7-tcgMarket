<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;

use App\Controller\MeController;
use App\Controller\UserController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('email', 'userName')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => 'user:item:get']
        ),
        new GetCollection(
            normalizationContext: ['groups' => 'user:collection:get']
        ),
        new Post(
            denormalizationContext: ['groups' => 'user:item:post'],
        ),
        new Patch(
            denormalizationContext: ['groups' => 'user:item:put']
        ),
        new Delete(
            normalizationContext: ['groups' => 'user:item:delete']
        ),
        new Get(
            uriTemplate: '/me',
            controller: MeController::class,
            normalizationContext: ['groups' => 'me'],
            read: false,
            name: 'me'
        )
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'cardUser:item:get', 
        'cardInSell:item:get', 
        'user:item:get',
        'user:collection:get',
        'user:item:delete',
        'me'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email]
    #[Groups([
        'user:item:post', 
        'user:item:get',
        'user:collection:get',
        'user:item:put',
        'me'
    ])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups([
        'user:item:post', 
        'user:item:get',
        'user:collection:get',
        'me'
    ])]
    private array $roles = [];

    #[Assert\Regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/')]
    private ?string $plainPassword = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column(length: 255)]
    #[Assert\Regex('/^\$2[aby]\$[0-9]{2}\$[A-Za-z0-9\/\.]{53}$/')]
    #[Groups([
        'user:item:post', 
    ])]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(min: 3, max: 16)]
    #[Groups([
        'cardUser:item:get', 
        'cardInSell:item:get', 
        'user:item:post', 
        'user:item:get',
        'user:collection:get',
        'user:item:put',
        'me'
    ])]
    private ?string $userName = null;

    #[ORM\Column(length: 15)]
    #[Assert\Regex('^((\+|00)33\s?|0)[67](\s?\d{2}){4}$^')]
    #[Groups([
        'user:item:post', 
        'user:item:get',
        'user:collection:get',
        'user:item:put',
        'me'
    ])]
    private ?string $phoneNumber = null;

    #[ORM\OneToOne(mappedBy: 'fkIdUser', cascade: ['persist', 'remove'])]
    #[Groups([
        'user:item:get',
        'user:item:put'
    ])]
    private ?UserInfo $userInfo = null;

    #[ORM\OneToMany(mappedBy: 'fkIdUser', targetEntity: Command::class)]
    private Collection $commands;

    #[ORM\OneToMany(mappedBy: 'fkIdUser', targetEntity: CardUser::class)]
    private Collection $cardUsers;

    use TimestampableEntity;

    public function __construct()
    {
        $this->commands = new ArrayCollection();
        $this->cardUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

        /**
     * Get the value of plainPassword
     */ 
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */ 
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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
