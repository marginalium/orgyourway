<?php

namespace App\Entity;

use App\Transformer\CsvDataTransformer;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Entity]
#[Table(name: 'events')]
class Event
{
    #[Id, GeneratedValue, Column]
    private ?int $id = null;

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
    public function getEventName(): string
    {
        return $this->eventName;
    }

    /**
     * @param string $eventName
     * @return Event
     */
    public function setEventName(string $eventName): self
    {
        $this->eventName = $eventName;
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
     * @return Event
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