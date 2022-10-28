<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{Column,
    CustomIdGenerator,
    Entity,
    GeneratedValue,
    HasLifecycleCallbacks,
    Id,
    OneToMany,
    PrePersist,
    PreUpdate,
    Table};
use Exception;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: UserRepository::class)]
#[Table(name: 'users')]
#[HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Id]
    #[Column(type: 'uuid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?int $id = null;

    #[Column(length: 180, unique: true)]
    private ?string $email = null;

    #[Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[Column]
    private ?string $password = null;

    #[Column(
        name: 'first_name',
        type: Types::STRING,
        nullable: true
    )]
    private ?string $firstName;

    #[Column(
        name: 'last_name',
        type: Types::STRING,
        nullable: true
    )]
    private ?string $lastName;

    #[Column(
        type: Types::STRING,
        nullable: true
    )]
    private ?string $alias;

    #[Column(
        name: 'is_subscribed',
        type: Types::BOOLEAN,
        nullable: true
    )]
    private ?bool $isSubscribed = null;

    #[Column(
        name: 'subscribed_at',
        type: Types::DATETIME_MUTABLE,
        nullable: true
    )]
    private ?DateTime $subscribedAt = null;

    #[Column(
        name: 'unsubscribed_at',
        type: Types::DATETIME_MUTABLE,
        nullable: true
    )]
    private ?DateTime $unsubscribedAt = null;

    #[Column(
        name: 'registered_at',
        type: Types::DATETIME_MUTABLE,
        nullable: true
    )]
    private ?DateTime $registeredAt;

    #[Column(
        name: 'created_at',
        type: Types::DATETIME_MUTABLE
    )]
    private ?DateTime $createdAt = null;

    #[Column(
        name: 'updated_at',
        type: Types::DATETIME_MUTABLE
    )]
    private ?DateTime $updatedAt = null;

    #[Column(
        name: 'deleted_at',
        type: Types::DATETIME_MUTABLE,
        nullable: true
    )]
    private DateTime $deletedAt;

    #[OneToMany(
        mappedBy: 'user',
        targetEntity: 'Ticket',
        cascade: ['persist']
    )]
    private ?Collection $tickets;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->setRoles([]);
        $this->setPassword(password_hash(random_bytes(16), PASSWORD_BCRYPT));
    }

    public function getId(): ?Uuid
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

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return User
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return User
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @param string|null $alias
     * @return User
     */
    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSubscribed(): bool
    {
        return $this->isSubscribed;
    }

    /**
     * @param bool $isSubscribed
     * @return User
     * @throws Exception
     */
    public function setIsSubscribed(bool $isSubscribed): self
    {
        $this->isSubscribed = $isSubscribed;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getSubscribedAt(): ?DateTime
    {
        return $this->subscribedAt;
    }

    /**
     * @param DateTime|string|null $subscribedAt
     * @return User
     * @throws Exception
     */
    public function setSubscribedAt(DateTime|string|null $subscribedAt): self
    {
        if (is_string($subscribedAt)) {
            $subscribedAt = new DateTime($subscribedAt);
        }
        $this->subscribedAt = $subscribedAt;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUnsubscribedAt(): ?DateTime
    {
        return $this->unsubscribedAt;
    }

    /**
     * @param DateTime|string|null $unsubscribedAt
     * @return User
     * @throws Exception
     */
    public function setUnsubscribedAt(DateTime|string|null $unsubscribedAt): self
    {
        if (is_string($unsubscribedAt)) {
            $unsubscribedAt = new DateTime($unsubscribedAt);
        }
        $this->unsubscribedAt = $unsubscribedAt;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getRegisteredAt(): ?DateTime
    {
        return $this->registeredAt;
    }

    /**
     * @param DateTime|string|null $registeredAt
     * @return User
     * @throws Exception
     */
    public function setRegisteredAt(DateTime|string|null $registeredAt): self
    {
        if (is_string($registeredAt)) {
            $registeredAt = new DateTime($registeredAt);
        }
        $this->registeredAt = $registeredAt;

        return $this;
    }

    /**
     * @return ?Collection
     */
    public function getTickets(): ?Collection
    {
        return $this->tickets;
    }

    /**
     * @param Collection $tickets
     * @return User
     */
    public function setTickets(Collection $tickets): self
    {
        $this->tickets = $tickets;

        return $this;
    }

    /**
     * @throws Exception
     */
    #[PrePersist, PreUpdate]
    public function updatedTimestamps(): void
    {
        $dateTimeNow = new DateTime('now');

        $this->setUpdatedAt($dateTimeNow);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }

        if ($this->isSubscribed && empty($this->subscribedAt)) {
            $this->setSubscribedAt(new DateTime('now'));
        } elseif (!$this->isSubscribed && !empty($this->subscribedAt)) {
            $this->setSubscribedAt(null);
        } elseif ($this->isSubscribed && !empty($this->unsubscribedAt)) {
            $this->setUnsubscribedAt(null);
        }
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return User
     */
    public function setCreatedAt(?DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDeletedAt(): DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @param DateTime $deletedAt
     * @return User
     */
    public function setDeletedAt(DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }
}
