<?php

namespace App\Service\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class OAuthUserManager
 * @package App\Service\Manager
 */
class OAuthUserManager
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * OAuthUserManager constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $this->entityManager = $registry->getEntityManager();
    }

    /**
     * @param UserResponseInterface $userResponse
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUserFromOAuthUserResponse(UserResponseInterface $userResponse): User
    {
        $userData = $userResponse->getData();

        $user = new User();
        $user->setUsername($userResponse->getNickname());
        $user->setEmail($userResponse->getEmail());
        $user->setPassword('google');
        $user->setGoogleId($userData['id'] ?? null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());

        $user->addRole('ROLE_OAUTH_USER');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateUserLastLogin(User $user): User
    {
        $user->setLastLogin(new \DateTime());

        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param string $email
     * @return User|object|null
     */
    public function findUserByEmail(string $email):? User
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy([
                'email' => $email
            ]);
    }
}
