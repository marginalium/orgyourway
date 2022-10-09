<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{
    Column,
    Entity,
    GeneratedValue,
    HasLifecycleCallbacks,
    Id,
    ManyToOne,
    PrePersist,
    PreUpdate,
    Table
};
use Exception;

#[Entity]
#[Table(name: 'tickets')]
#[HasLifecycleCallbacks]
class Ticket
{
    #[Id, GeneratedValue, Column]
    private ?int $id = null;

    #[Column(
        type: Types::STRING
    )]
    private string $source;

    #[Column(
        name: 'external_ticket_id',
        type: Types::STRING,
        nullable: true
    )]
    private ?string $externalTicketId;

    #[Column(
        name: 'gross_revenue_in_cents',
        type: Types::INTEGER,
        nullable: true
    )]
    private int $grossRevenueInCents;

    #[Column(
        name: 'ticket_revenue_in_cents',
        type: Types::INTEGER,
        nullable: true
    )]
    private int $ticketRevenueInCents;

    #[Column(
        name: 'third_party_fees_in_cents',
        type: Types::INTEGER,
        nullable: true
    )]
    private int $thirdPartyFeesInCents;

    #[Column(
        name: 'third_party_payment_processing_in_cents',
        type: Types::INTEGER,
        nullable: true
    )]
    private int $thirdPartyPaymentProcessingInCents;

    #[Column(
        name: 'tax_in_cents',
        type: Types::INTEGER,
        nullable: true
    )]
    private int $taxInCents;

    #[Column(
        type: Types::INTEGER
    )]
    private int $quantity = 1;

    #[Column(
        name: 'payment_type',
        type: Types::STRING,
        nullable: true
    )]
    private string $paymentType;

    #[Column(
        name: 'payment_status',
        type: Types::STRING,
        nullable: true
    )]
    private string $paymentStatus;

    #[Column(
        name: 'delivery_method',
        type: Types::STRING,
        nullable: true
    )]
    private string $deliveryMethod;

    #[Column(
        name: 'checked_in',
        type: Types::BOOLEAN
    )]
    private bool $checkedIn = false;

    #[Column(
        name: 'checked_in_at',
        type: Types::DATETIME_MUTABLE,
        nullable: true
    )]
    private ?DateTime $checkedInAt;

    #[Column(
        name: 'purchased_at',
        type: Types::DATETIME_MUTABLE,
        nullable: true
    )]
    private ?DateTime $purchasedAt;

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

    #[ManyToOne(
        targetEntity: 'User',
        cascade: ['persist'],
        fetch: 'LAZY',
        inversedBy: 'tickets'
    )]
    private User $user;

    #[ManyToOne(
        targetEntity: 'Event',
        cascade: ['persist'],
        fetch: 'LAZY',
        inversedBy: 'tickets'
    )]
    private ?Event $event = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Ticket
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return Ticket
     */
    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return string
     */
    public function getExternalTicketId(): string
    {
        return $this->externalTicketId;
    }

    /**
     * @param string $externalTicketId
     * @return Ticket
     */
    public function setExternalTicketId(string $externalTicketId): self
    {
        $this->externalTicketId = $externalTicketId;

        return $this;
    }

    /**
     * @return float
     */
    public function getGrossRevenueInCents(): float
    {
        return $this->grossRevenueInCents / 100;
    }

    /**
     * @param int $grossRevenueInCents
     * @return Ticket
     */
    public function setGrossRevenueInCents(int $grossRevenueInCents): self
    {
        $this->grossRevenueInCents = (int) ($grossRevenueInCents * 100);

        return $this;
    }

    /**
     * @return float
     */
    public function getTicketRevenueInCents(): float
    {
        return $this->ticketRevenueInCents / 100;
    }

    /**
     * @param int $ticketRevenueInCents
     * @return Ticket
     */
    public function setTicketRevenueInCents(int $ticketRevenueInCents): self
    {
        $this->ticketRevenueInCents = (int) ($ticketRevenueInCents * 100);

        return $this;
    }

    /**
     * @return float
     */
    public function getThirdPartyFeesInCents(): float
    {
        return $this->thirdPartyFeesInCents / 100;
    }

    /**
     * @param int $thirdPartyFeesInCents
     * @return Ticket
     */
    public function setThirdPartyFeesInCents(int $thirdPartyFeesInCents): self
    {
        $this->thirdPartyFeesInCents = (int) ($thirdPartyFeesInCents * 100);

        return $this;
    }

    /**
     * @return float
     */
    public function getThirdPartyPaymentProcessingInCents(): float
    {
        return $this->thirdPartyPaymentProcessingInCents / 100;
    }

    /**
     * @param int $thirdPartyPaymentProcessingInCents
     * @return Ticket
     */
    public function setThirdPartyPaymentProcessingInCents(int $thirdPartyPaymentProcessingInCents): self
    {
        $this->thirdPartyPaymentProcessingInCents = (int) ($thirdPartyPaymentProcessingInCents * 100);

        return $this;
    }

    /**
     * @return float
     */
    public function getTaxInCents(): float
    {
        return $this->taxInCents / 100;
    }

    /**
     * @param int $taxInCents
     * @return Ticket
     */
    public function setTaxInCents(int $taxInCents): self
    {
        $this->taxInCents = (int) ($taxInCents * 100);

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return Ticket
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @return Ticket
     */
    public function setPaymentType(string $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentStatus(): string
    {
        return $this->paymentStatus;
    }

    /**
     * @param string $paymentStatus
     * @return Ticket
     */
    public function setPaymentStatus(string $paymentStatus): self
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeliveryMethod(): string
    {
        return $this->deliveryMethod;
    }

    /**
     * @param string $deliveryMethod
     * @return Ticket
     */
    public function setDeliveryMethod(string $deliveryMethod): self
    {
        $this->deliveryMethod = $deliveryMethod;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCheckedIn(): bool
    {
        return $this->checkedIn;
    }

    /**
     * @param bool $checkedIn
     * @return Ticket
     * @throws Exception
     */
    public function setCheckedIn(bool $checkedIn): self
    {
        $this->checkedIn = $checkedIn;
        if ($checkedIn && empty($this->checkedInAt)) {
            $this->setCheckedInAt(new DateTime('now'));
        }

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCheckedInAt(): ?DateTime
    {
        return $this->checkedInAt;
    }

    /**
     * @param DateTime|string|null $checkedInAt
     * @return Ticket
     * @throws Exception
     */
    public function setCheckedInAt(DateTime|string|null $checkedInAt): self
    {
        if (is_string($checkedInAt)) {
            $checkedInAt = new DateTime($checkedInAt);
        }
        if (empty($this->checkedInAt)) {
            $this->checkedInAt = $checkedInAt;
        }

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getPurchasedAt(): ?DateTime
    {
        return $this->purchasedAt;
    }

    /**
     * @param DateTime|string|null $purchasedAt
     * @return Ticket
     * @throws Exception
     */
    public function setPurchasedAt(DateTime|string|null $purchasedAt): self
    {
        if (is_string($purchasedAt)) {
            $purchasedAt = new DateTime($purchasedAt);
        }
        if (empty($this->purchasedAt)) {
            $this->purchasedAt = $purchasedAt;
        }

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
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return Ticket
     */
    public function setCreatedAt(?DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return Ticket
     */
    public function setUpdatedAt(?DateTime $updatedAt): self
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
     * @return Ticket
     */
    public function setDeletedAt(DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Ticket
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return ?Event
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    /**
     * @param Event $event
     * @return Ticket
     */
    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
