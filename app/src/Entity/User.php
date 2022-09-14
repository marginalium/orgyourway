<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Transformer\CsvDataTransformer;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

    private ?UploadedFile $file = null;

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
        return $this->subscribed;
    }

    /**
     * @param bool $subscribed
     * @return User
     */
    public function setSubscribed(bool $subscribed): self
    {
        $this->subscribed = $subscribed;
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
     * @param DateTime|null $subscribedAt
     * @return User
     */
    public function setSubscribedAt(?DateTime $subscribedAt): self
    {
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
     * @param DateTime|null $unsubscribedAt
     * @return User
     */
    public function setUnsubscribedAt(?DateTime $unsubscribedAt): self
    {
        $this->unsubscribedAt = $unsubscribedAt;
        return $this;
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
     * @return User
     */
    public function setCreatedAt(DateTime $createdAt): self
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

    /**
     * @return Collection
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    /**
     * @param Collection $events
     * @return User
     */
    public function setEvents(Collection $events): self
    {
        $this->events = $events;
        return $this;
    }
}
