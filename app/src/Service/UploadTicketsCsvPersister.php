<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Ticket;
use App\Entity\User;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UploadTicketsCsvPersister
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TicketRepository $ticketRepository,
        private UserRepository $userRepository
    ) {}

    public function __invoke(array $ticketArray, Event $event): array
    {
        $ticketEntityArray = $this->ticketRepository->getTicketsByExternalId($ticketArray);
        $userEntityArray = $this->userRepository->getUsersByEmail($ticketArray);

        $writeCounts = $this->writeTicketEntities($ticketArray, $ticketEntityArray, $event);

        $this->entityManager->flush();

        return $writeCounts;
    }

    public function writeTicketEntities(array $ticketArray, array $ticketEntityArray, Event $event): array
    {
        $writeCount = [
            'updated' => 0,
            'created' => 0,
            'total' => 0
        ];

        foreach ($ticketArray as $ticketRow) {
            if (!in_array($ticketRow['ticket']['external_ticket_id'], $ticketEntityArray)) {
                $ticket = new Ticket();
                $writeCount['created']++;
            } else {
                $writeCount['updated']++;
            }
            $ticket->setExternalTicketId($ticketRow['ticket']['external_ticket_id']);
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

            $user = new User();
            $user->setEmail($ticketRow['user']['email']);
            $user->setPassword(password_hash(random_bytes(16), PASSWORD_BCRYPT));
            $user->setFirstName($ticketRow['user']['first_name']);
            $user->setLastName($ticketRow['user']['last_name']);

            $ticket->setUser($user);

            $this->entityManager->persist($ticket);
            $writeCount['total']++;
        }

        return $writeCount;
    }
}