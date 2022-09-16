<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\Table;

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
        type: Types::STRING
    )]
    private string $externalTicketId;

    #[Column(
        name: 'gross_revenue_in_cents',
        type: Types::INTEGER
    )]
    private int $grossRevenueInCents;

    #[Column(
        name: 'ticket_revenue_in_cents',
        type: Types::INTEGER
    )]
    private int $ticketRevenueInCents;

    #[Column(
        name: 'third_party_fees_in_cents',
        type: Types::INTEGER
    )]
    private int $thirdPartyFeesInCents;

    #[Column(
        name: 'third_party_payment_processing_in_cents',
        type: Types::INTEGER
    )]
    private int $thirdPartyPaymentProcessingInCents;

    #[Column(
        name: 'tax_in_cents',
        type: Types::INTEGER
    )]
    private int $taxInCents;

    #[Column(
        type: Types::INTEGER
    )]
    private int $quantity;

    #[Column(
        name: 'payment_type',
        type: Types::STRING
    )]
    private string $paymentType;

    #[Column(
        name: 'payment_status',
        type: Types::STRING
    )]
    private string $paymentStatus;

    #[Column(
        name: 'delivery_method',
        type: Types::STRING
    )]
    private string $deliveryMethod;

    #[Column(
        name: 'purchased_at',
        type: Types::DATETIME_MUTABLE
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

    #[ManyToOne(targetEntity: 'User')]
    private User $user;

    #[ManyToOne(targetEntity: 'Event')]
    private Event $event;

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
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
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
     */
    public function setExternalTicketId(string $externalTicketId): void
    {
        $this->externalTicketId = $externalTicketId;
    }

    /**
     * @return int
     */
    public function getGrossRevenueInCents(): int
    {
        return $this->grossRevenueInCents;
    }

    /**
     * @param int $grossRevenueInCents
     */
    public function setGrossRevenueInCents(int $grossRevenueInCents): void
    {
        $this->grossRevenueInCents = $grossRevenueInCents;
    }

    /**
     * @return int
     */
    public function getTicketRevenueInCents(): int
    {
        return $this->ticketRevenueInCents;
    }

    /**
     * @param int $ticketRevenueInCents
     */
    public function setTicketRevenueInCents(int $ticketRevenueInCents): void
    {
        $this->ticketRevenueInCents = $ticketRevenueInCents;
    }

    /**
     * @return int
     */
    public function getThirdPartyFeesInCents(): int
    {
        return $this->thirdPartyFeesInCents;
    }

    /**
     * @param int $thirdPartyFeesInCents
     */
    public function setThirdPartyFeesInCents(int $thirdPartyFeesInCents): void
    {
        $this->thirdPartyFeesInCents = $thirdPartyFeesInCents;
    }

    /**
     * @return int
     */
    public function getThirdPartyPaymentProcessingInCents(): int
    {
        return $this->thirdPartyPaymentProcessingInCents;
    }

    /**
     * @param int $thirdPartyPaymentProcessingInCents
     */
    public function setThirdPartyPaymentProcessingInCents(int $thirdPartyPaymentProcessingInCents): void
    {
        $this->thirdPartyPaymentProcessingInCents = $thirdPartyPaymentProcessingInCents;
    }

    /**
     * @return int
     */
    public function getTaxInCents(): int
    {
        return $this->taxInCents;
    }

    /**
     * @param int $taxInCents
     */
    public function setTaxInCents(int $taxInCents): void
    {
        $this->taxInCents = $taxInCents;
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
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
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
     */
    public function setPaymentType(string $paymentType): void
    {
        $this->paymentType = $paymentType;
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
     */
    public function setPaymentStatus(string $paymentStatus): void
    {
        $this->paymentStatus = $paymentStatus;
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
     */
    public function setDeliveryMethod(string $deliveryMethod): void
    {
        $this->deliveryMethod = $deliveryMethod;
    }

    /**
     * @return DateTime|null
     */
    public function getPurchasedAt(): ?DateTime
    {
        return $this->purchasedAt;
    }

    /**
     * @param DateTime|null $purchasedAt
     */
    public function setPurchasedAt(?DateTime $purchasedAt): void
    {
        $this->purchasedAt = $purchasedAt;
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
     */
    public function setCreatedAt(?DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
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
     */
    public function setUpdatedAt(?DateTime $updatedAt): void
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }
}
