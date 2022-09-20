<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Ticket;
use App\Entity\User;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class UploadTicketsCsvPersister
{
    private const DEFAULT_PROVIDER = 'eventbrite';

    public function __construct(
        private EntityManagerInterface $entityManager,
        private TicketRepository $ticketRepository,
        private UserRepository $userRepository
    ) {}

    public function __invoke(array $ticketArray, Event $event): array
    {
        $ticketCollection = $this->ticketRepository->getTicketsByExternalId($ticketArray);
        $userCollection = $this->userRepository->getUsersByEmail($ticketArray);

        $writeCounts = $this->writeTicketEntities($ticketArray, $ticketCollection, $userCollection, $event);

        return $writeCounts;
    }

    public function writeTicketEntities(
        array $ticketArray,
        ArrayCollection $ticketCollection,
        ArrayCollection $userCollection,
        Event $event
    ): array {
        $writeCount = [
            'updated' => 0,
            'created' => 0,
            'total' => 0
        ];

        foreach ($ticketArray as $ticketRow) {
            $externalTicketId = strtolower($ticketRow['ticket']['external_ticket_id']);
            $ticket = $ticketCollection->filter(
            //https://www.php.net/manual/en/functions.arrow.php
                fn($ticket) => $ticket->getExternalTicketId() == $externalTicketId
            )->first();

            $writeCount['total']++;
            if (empty($ticket)) {
                $ticket = new Ticket();
                $writeCount['created']++;
            } else {
                $writeCount['updated']++;
            }

            $ticket->setSource(self::DEFAULT_PROVIDER);
            $ticket->setExternalTicketId(strtolower($ticketRow['ticket']['external_ticket_id']));
            $ticket->setPurchasedAt($ticketRow['ticket']['purchased_at']);
            $ticket->setGrossRevenueInCents(
                (int) ($ticketRow['ticket']['gross_revenue_in_cents'] * 100)
            );
            $ticket->setTicketRevenueInCents(
                (int) ($ticketRow['ticket']['ticket_revenue_in_cents'] * 100)
            );
            $ticket->setThirdPartyFeesInCents(
                (int) ($ticketRow['ticket']['third_party_fees_in_cents'] * 100)
            );
            $ticket->setThirdPartyPaymentProcessingInCents(
                (int) ($ticketRow['ticket']['third_party_payment_processing_in_cents'] * 100)
            );
            $ticket->setTaxInCents(
                (int) ($ticketRow['ticket']['tax_in_cents'] * 100)
            );
            $ticket->setQuantity($ticketRow['ticket']['quantity']);
            $ticket->setPaymentType($ticketRow['ticket']['payment_type']);
            $ticket->setPaymentStatus($ticketRow['ticket']['payment_status']);
            $ticket->setDeliveryMethod($ticketRow['ticket']['delivery_method']);

            $email = strtolower($ticketRow['user']['email']);

            $user = $userCollection->filter(
                fn($userEntity) => $userEntity->getEmail() == $email
            )->first();

            if (empty($user)) {
                $user = new User();
            }

            $user->setEmail($email);
            $user->setPassword(password_hash(random_bytes(16), PASSWORD_BCRYPT));
            $user->setFirstName($ticketRow['user']['first_name']);
            $user->setLastName($ticketRow['user']['last_name']);
            $this->entityManager->persist($user);

            $ticket->setUser($user);
            $ticket->setEvent($event);

            $this->entityManager->persist($ticket);
        }

        $this->entityManager->flush();

        return $writeCount;
    }
}