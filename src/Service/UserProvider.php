<?php

namespace App\Service;

use App\Entity\User;
use App\Service\Manager\OAuthUserManager;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;

/**
 * Class UserProvider
 * @package App\Service
 */
class UserProvider extends FOSUBUserProvider
{
    /**
     * @var OAuthUserManager $oAuthUserManager
     */
    private $oAuthUserManager;

    /**
     * UserProvider constructor.
     * @param UserManagerInterface $userManager
     * @param array $properties
     * @param OAuthUserManager $oAuthUserManager
     */
    public function __construct(
        UserManagerInterface $userManager,
        array $properties,
        OAuthUserManager $oAuthUserManager
    ) {
        parent::__construct($userManager, $properties);

        $this->oAuthUserManager = $oAuthUserManager;
    }

    /**
     * @param UserResponseInterface $response
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response): User
    {
        $user = $this->oAuthUserManager
            ->findUserByEmail(
                $response->getEmail()
            );

        if ($user instanceof User) {
            return $this->oAuthUserManager
                ->updateUserLastLogin($user);
        }

        return $this->oAuthUserManager
            ->createUserFromOAuthUserResponse($response);
    }
}