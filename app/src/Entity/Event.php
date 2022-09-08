<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'events')]
class Event
{
    #[Id, Column(
        type: Types::INTEGER
    )]
    private ?int $id;

    #[Column(
        name: 'event_name',
        type: Types::STRING
    )]
    private string $eventName;

    #[Column(
        name: 'attendance_count',
        type: Types::INTEGER
    )]
    private int $attendanceCount;

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

    #[ManyToMany(targetEntity: 'User', inversedBy: 'events')]
    #[JoinTable(name: 'event_user')]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[InverseJoinColumn(name: 'event_id', referencedColumnName: 'id')]
    private Collection $users;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEventName(): string
    {
        return $this->eventName;
    }

    /**
     * @param string $eventName
     */
    public function setEventName(string $eventName): void
    {
        $this->eventName = $eventName;
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
     */
    public function setAttendanceCount(int $attendanceCount): void
    {
        $this->attendanceCount = $attendanceCount;
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
     */
    public function setAttendanceCap(?int $attendanceCap): void
    {
        $this->attendanceCap = $attendanceCap;
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
     */
    public function setTicketCostInCents(int $ticketCostInCents): void
    {
        $this->ticketCostInCents = $ticketCostInCents;
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
     */
    public function setStartedAt(DateTime $startedAt): void
    {
        $this->startedAt = $startedAt;
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
     */
    public function setEndedAt(DateTime $endedAt): void
    {
        $this->endedAt = $endedAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
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
}