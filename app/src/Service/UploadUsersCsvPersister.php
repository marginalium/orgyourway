<?php

namespace App\Service;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class UploadUsersCsvPersister
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function __invoke(array $userArray): array
    {
         $writeCounts['user'] = $this->createUserEntities($userArray['user']);
         return $writeCounts;
    }

    /**
     * @throws \Exception
     */
    public function createUserEntities(array $userArray): array
    {
        $userRepo = $this->entityManager->getRepository(User::class);
        $writeCount = [
            'updated' => 0,
            'created' => 0,
            'total' => 0
        ];

        foreach ($userArray as $userRow) {
            $user = $userRepo->findOneBy(['email' => $userRow['email']]);
            if (empty($user)) {
                $user = new User();
                $user->setEmail($userRow['email']);
                $user->setIsSubscribed($userRow['is_subscribed']);
                $writeCount['created']++;
            } else {
                if (
                    !$user->isSubscribed() &&
                    empty($user->getSubscribedAt()) &&
                    $userRow['is_subscribed']
                ) {
                    $user->setIsSubscribed($userRow['is_subscribed']);
                    $user->setSubscribedAt(new DateTime('now'));
                }
                $writeCount['updated']++;
            }
            $user->setFirstName($userRow['first_name']);
            $user->setLastName($userRow['last_name']);
            $user->setUnsubscribedAt(new DateTime($userRow['unsubscribed_at']));
            $user->setPassword(password_hash(random_bytes(16), PASSWORD_BCRYPT));
            $this->entityManager->persist($user);
            $writeCount['total']++;
        }

        $this->entityManager->flush();

        return $writeCount;
    }
}
