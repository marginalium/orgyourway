<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UploadUsersCsvPersister
{
    public const SUBSCRIBED_YES = 'Yes';
    public const SUBSCRIBED_NO = 'No';

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function __invoke(array $userArray): array
    {
        $userRepository = $this->entityManager->getRepository(User::class);

        $writeCounts['user'] = $this->writeUserEntities($userArray['user'], $userRepository);

        return $writeCounts;
    }

    /**
     * @throws Exception
     */
    public function writeUserEntities(array $userArray, UserRepository $userRepository): array
    {
        $writeCount = [
            'updated' => 0,
            'created' => 0,
            'total' => 0
        ];

        foreach ($userArray as $userRow) {
            $user = $userRepository->findOneBy(['email' => $userRow['email']]);
            if (empty($user)) {
                $user = new User();
                $user->setEmail(strtolower($userRow['email']));
                $writeCount['created']++;
            } else {
                $writeCount['updated']++;
            }
            if ($userRow['is_subscribed'] == self::SUBSCRIBED_YES) {
                $user->setIsSubscribed(true);
            } elseif ($userRow['is_subscribed'] == self::SUBSCRIBED_NO || empty($userRow['is_subscribed'])) {
                $user->setIsSubscribed(false);
            }
            if (
                !empty($userRow['unsubscribed_at']) &&
                empty($user->getUnsubscribedAt())
            ) {
                $user->setUnsubscribedAt(new DateTime($userRow['unsubscribed_at']));
            }
            $user->setFirstName($userRow['first_name']);
            $user->setLastName($userRow['last_name']);
            $user->setPassword(password_hash(random_bytes(16), PASSWORD_BCRYPT));
            $this->entityManager->persist($user);
            $writeCount['total']++;
        }
        $this->entityManager->flush();

        return $writeCount;
    }
}
