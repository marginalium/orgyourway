<?php

namespace App\Service;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;

class UploadTicketsCsvPersister
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function __invoke(array $ticketArray): array
    {
        $ticketRepository = $this->entityManager->getRepository(Ticket::class);

        $writeCounts['ticket'] = $this->writeTicketEntities($ticketArray['ticket'], $ticketRepository);
        $writeCounts['user'] = $this->writeUserEntities($ticketArray['user'], $ticketRepository);
        $writeCounts['event'] = $this->writeEventEntities($ticketArray['event'], $ticketRepository);

        $this->entityManager->flush();

        return $writeCounts;
    }

    public function writeTicketEntities(array $ticketArray, TicketRepository $ticketRepository): array
    {
        $writeCount = [
            'updated' => 0,
            'created' => 0,
            'total' => 0
        ];

        foreach ($ticketArray as $ticketRow) {
            $ticket = $ticketRepository->findOneBy(['external_ticket_id' => $ticketRow['external_ticket_id']]);
            if (empty($ticket)) {
                $ticket = new Ticket();
                $writeCount['created']++;
            } else {
                $writeCount['updated']++;
            }
            $ticket->setExternalTicketId($ticketRow['external_ticket_id']);
            $ticket->setPurchasedAt($ticketRow['purchased_at']);
            $ticket->setGrossRevenueInCents(
                (int) ($ticketRow['gross_revenue_in_cents'] * 100)
            );
            $ticket->setTicketRevenueInCents(
                (int) ($ticketRow['ticket_revenue_in_cents'] * 100)
            );
            $ticket->setThirdPartyFeesInCents(
                (int) ($ticketRow['third_party_fees_in_cents'] * 100)
            );
            $ticket->setThirdPartyPaymentProcessingInCents(
                (int) ($ticketRow['third_party_payment_processing_in_cents'] * 100)
            );
            $ticket->setTaxInCents(
                (int) ($ticketRow['tax_in_cents'] * 100)
            );
            $ticket->setQuantity($ticketRow['quantity']);
            $ticket->setPaymentType($ticketRow['payment_type']);
            $ticket->setPaymentStatus($ticketRow['payment_status']);
            $ticket->setDeliveryMethod($ticketRow['delivery_method']);
            $this->entityManager->persist($ticket);
            $writeCount['total']++;
        }

        return $writeCount;
    }

    public function writeUserEntities(array $userArray, TicketRepository $ticketRepository): array
    {
        $writeCount = [
            'updated' => 0,
            'created' => 0,
            'total' => 0
        ];

        return $writeCount;
    }

    public function writeEventEntities(array $eventArray, TicketRepository $ticketRepository): array
    {
        $writeCount = [
            'updated' => 0,
            'created' => 0,
            'total' => 0
        ];

        return $writeCount;
    }
}