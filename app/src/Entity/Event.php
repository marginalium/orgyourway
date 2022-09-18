<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{
    Column,
    Entity,
    GeneratedValue,
    HasLifecycleCallbacks,
    Id,
    OneToMany,
    PrePersist,
    PreUpdate,
    Table
};

#[Entity]
#[Table(name: 'events')]
#[HasLifecycleCallbacks]
class Event
{
    #[Id, GeneratedValue, Column]
    private ?int $id = null;

    #[Column(
        name: 'name',
        type: Types::STRING
    )]
    private string $name;

    #[Column(
        name: 'attendance_cap',
        type: Types::INTEGER,
        nullable: true
    )]
    private ?int $attendanceCap;

    #[Column(
        name: 'ticket_cost_in_cents',
        type: Types::INTEGER,
        nullable: true
    )]
    private int $ticketCostInCents;

    #[Column(
        name: 'started_at',
        type: Types::DATETIME_MUTABLE
    )]
    private DateTime $startedAt;

    #[Column(
        name: 'ended_at',
        type: Types:: DATETIME_MUTABLE
    )]
    private DateTime $endedAt;

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
        mappedBy: 'event',
        targetEntity: 'Ticket',
        cascade: ['persist']
    )]
    private ?Collection $tickets;

    private array $eventDate;

    private string $fullName;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Event
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Event
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttendanceCount(): int
    {
        return $this->attendanceCount;
    }

    /**
     * @param int $attendanceCount
     * @return Event
     */
    public function setAttendanceCount(int $attendanceCount): self
    {
        $this->attendanceCount = $attendanceCount;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAttendanceCap(): ?int
    {
        return $this->attendanceCap;
    }

    /**
     * @param int|null $attendanceCap
     * @return Event
     */
    public function setAttendanceCap(?int $attendanceCap): self
    {
        $this->attendanceCap = $attendanceCap;
        return $this;
    }

    /**
     * @return int
     */
    public function getTicketCostInCents(): int
    {
        return $this->ticketCostInCents;
    }

    /**
     * @param int $ticketCostInCents
     * @return Event
     */
    public function setTicketCostInCents(int $ticketCostInCents): self
    {
        $this->ticketCostInCents = $ticketCostInCents;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartedAt(): DateTime
    {
        return $this->startedAt;
    }

    /**
     * @param DateTime $startedAt
     * @return Event
     */
    public function setStartedAt(DateTime $startedAt): self
    {
        $this->startedAt = $startedAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEndedAt(): DateTime
    {
        return $this->endedAt;
    }

    /**
     * @param DateTime $endedAt
     * @return Event
     */
    public function setEndedAt(DateTime $endedAt): self
    {
        $this->endedAt = $endedAt;
        return $this;
    }

    /**
     * @return array
     */
    public function getEventDate(): array
    {
        return [
            'start' => $this->getStartedAt(),
            'end' => $this->getEndedAt()
        ];
    }

    public function setEventDate(array $eventDate): self
    {
        $this->setStartedAt($eventDate['start']);
        $this->setEndedAt($eventDate['end']);

        return $this;
    }

    public function getFullName(): string
    {
        return $this->getName() . ': ' . $this->getStartedAt()->format('Y-m-d H:i:s') . ' - ' . $this->getEndedAt()->format('Y-m-d H:i:s');
    }

    /**
     * @return Collection
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    /**
     * @param Collection $tickets
     */
    public function setTickets(Collection $tickets): void
    {
        $this->tickets = $tickets;
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
     * @return ?DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param ?DateTime $createdAt
     * @return Event
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
     * @return Event
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
     * @return Event
     */
    public function setDeletedAt(DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }
}