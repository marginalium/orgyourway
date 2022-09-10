<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
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
        type: Types::BOOLEAN
    )]
    private bool $subscribed;

    #[Column(
        name: 'subscribed_at',
        type: Types::DATETIME_MUTABLE,
        nullable: true
    )]
    private ?DateTime $subscribedAt;

    #[Column(
        name: 'unsubscribed_at',
        type: Types::DATETIME_MUTABLE,
        nullable: true
    )]
    private ?DateTime $unsubscribedAt;

    #[Column(
        name: 'created_at',
        type: Types::DATETIME_MUTABLE
    )]
    private DateTime $createdAt;

    #[Column(
        name: 'updated_at',
        type: Types::DATETIME_MUTABLE
    )]
    private DateTime $updatedAt;

    #[Column(
        name: 'deleted_at',
        type: Types::DATETIME_MUTABLE,
        nullable: true
    )]
    private DateTime $deletedAt;

    #[ManyToMany(targetEntity: 'Event', mappedBy: 'users')]
    private Collection $events;

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
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
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
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
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
     */
    public function setAlias(?string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return bool
     */
    public function isSubscribed(): bool
    {
        return $this->subscribed;
    }

    /**
     * @param bool $subscribed
     */
    public function setSubscribed(bool $subscribed): void
    {
        $this->subscribed = $subscribed;
    }

    /**
     * @return DateTime|null
     */
    public function getSubscribedAt(): ?DateTime
    {
        return $this->subscribedAt;
    }

    /**
     * @param DateTime|null $subscribedAt
     */
    public function setSubscribedAt(?DateTime $subscribedAt): void
    {
        $this->subscribedAt = $subscribedAt;
    }

    /**
     * @return DateTime|null
     */
    public function getUnsubscribedAt(): ?DateTime
    {
        return $this->unsubscribedAt;
    }

    /**
     * @param DateTime|null $unsubscribedAt
     */
    public function setUnsubscribedAt(?DateTime $unsubscribedAt): void
    {
        $this->unsubscribedAt = $unsubscribedAt;
    }
    
    #[PrePersist, PreUpdate]
    public function updatedTimestamps(): void
    {
        $dateTimeNow = new DateTime('now');

        $this->setUpdatedAt($dateTimeNow);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
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
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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
     */
    public function setDeletedAt(DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return Collection
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    /**
     * @param Collection $events
     */
    public function setEvents(Collection $events): void
    {
        $this->events = $events;
    }
}
