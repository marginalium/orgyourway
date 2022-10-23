<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UploadUsersCsvPersister
{
    public const SUBSCRIBED_NO = 'No';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DoctrineObject         $doctrineHydrator,
        private readonly UserRepository         $userRepository
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(array $userArray): array
    {
        $userCollection = $this->userRepository->getUsersByEmail($userArray);

        $writeCounts['user'] = $this->writeUserEntities($userArray, $userCollection);

        return $writeCounts;
    }

    /**
     * @throws Exception
     */
    public function writeUserEntities(
        array $userArray,
        ArrayCollection $userCollection
    ): array {
        $writeCount = [
            'updated' => 0,
            'created' => 0,
            'total' => 0
        ];

        foreach ($userArray as $userRow) {
            $user = $userCollection->filter(
            //https://www.php.net/manual/en/functions.arrow.php
                fn($user) => $user->getEmail() == strtolower($userRow['email'])
            )->first();

            $writeCount['total']++;
            if (empty($user)) {
                $user = new User();
                $writeCount['created']++;
            } else {
                $writeCount['updated']++;
            }

            $userData = [
                'email' => strtolower($userRow['email']),
                'first_name' => $userRow['first_name'],
                'last_name' => $userRow['last_name'],
                'is_subscribed' => !($userRow['is_subscribed'] == self::SUBSCRIBED_NO ||
                    empty($userRow['is_subscribed'])),
                'unsubscribed_at' => !empty($userRow['unsubscribed_at']) && empty($user->getUnsubscribedAt()) ?
                    new DateTime($userRow['unsubscribed_at']) : $user->getUnsubscribedAt(),
                'password' => password_hash(random_bytes(16), PASSWORD_BCRYPT)
            ];

            $user = $this->doctrineHydrator->hydrate($userData, $user);

            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();

        return $writeCount;
    }
}
