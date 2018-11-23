<?php

namespace App\Service;

use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;

/**
 * Class UserProvider
 * @package App\Service
 */
class UserProvider extends FOSUBUserProvider
{
    /**
     * @var RegistryInterface $registry
     */
    private $registry;

    /**
     * UserProvider constructor.
     * @param UserManagerInterface $userManager
     * @param array $properties
     * @param RegistryInterface $registry
     */
    public function __construct(UserManagerInterface $userManager, array $properties, RegistryInterface $registry)
    {
        parent::__construct($userManager, $properties);

        $this->registry = $registry;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        dump($response);
        die();
    }
}