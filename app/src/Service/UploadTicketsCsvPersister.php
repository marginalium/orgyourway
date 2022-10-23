<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Ticket;
use App\Entity\User;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UploadTicketsCsvPersister
{
    private const DEFAULT_PROVIDER = 'eventbrite';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DoctrineObject         $doctrineHydrator,
        private readonly TicketRepository       $ticketRepository,
        private readonly UserRepository         $userRepository
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(array $ticketArray, Event $event): array
    {
        $ticketCollection = $this->ticketRepository->getTicketsByExternalId($ticketArray);
        $userCollection = $this->userRepository->getUsersByEmail($ticketArray);

        return $this->writeTicketEntities($ticketArray, $ticketCollection, $userCollection, $event);
    }

    /**
     * @throws Exception
     */
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
            $user = $this->hydrateUserData($ticketRow, $userCollection);

            $event = $this->hydrateEventData($ticketRow, $event);

            $ticket = $ticketCollection->filter(
            //https://www.php.net/manual/en/functions.arrow.php
                fn($ticket) => $ticket->getExternalTicketId() == strtolower($ticketRow['external_ticket_id'])
            )->first();

            $writeCount['total']++;
            if (empty($ticket)) {
                $ticket = new Ticket();
                $writeCount['created']++;
            } else {
                $writeCount['updated']++;
            }

            $ticketData = [
                'source' => self::DEFAULT_PROVIDER,
                'external_ticket_id' => strtolower($ticketRow['external_ticket_id']),
                'purchased_at' => $ticketRow['purchased_at'],
                'gross_revenue_in_cents' => $ticketRow['gross_revenue_in_cents'],
                'ticket_revenue_in_cents' => $ticketRow['ticket_revenue_in_cents'],
                'third_party_fees_in_cents' => $ticketRow['third_party_fees_in_cents'],
                'third_party_payment_processing_in_cents' => $ticketRow['third_party_payment_processing_in_cents'],
                'tax_in_cents' => $ticketRow['tax_in_cents'],
                'quantity' => (int) ($ticketRow['quantity']),
                'payment_type' => $ticketRow['payment_type'],
                'payment_status' => $ticketRow['payment_status'],
                'delivery_method' => $ticketRow['delivery_method'],
                'user' => $user,
                'event' => $event
            ];

            $ticket = $this->doctrineHydrator->hydrate($ticketData, $ticket);

            $this->entityManager->persist($ticket);
        }

        $this->entityManager->flush();

        return $writeCount;
    }

    /**
     * @throws Exception
     */
    protected function hydrateUserData(array $data, ArrayCollection $userCollection): User
    {
        $userData = [
            'email' => strtolower($data['user']['email']),
            'password' => password_hash(random_bytes(16), PASSWORD_BCRYPT),
            'first_name' => $data['user']['first_name'],
            'last_name' => $data['user']['last_name']
        ];

        $user = $userCollection->filter(
            fn($userEntity) => $userEntity->getEmail() == $userData['email']
        )->first();

        if (empty($user)) {
            $user = new User();
        }

        return $this->doctrineHydrator->hydrate($userData, $user);
    }

    protected function hydrateEventData(array $data, Event $event): Event
    {
        $eventData = [
            'name' => $data['event']['name'],
            'venue_name' => $data['event']['venue_name'],
            'external_venue_id' => $data['event']['external_venue_id']
        ];

        return $this->doctrineHydrator->hydrate($eventData, $event);
    }
}