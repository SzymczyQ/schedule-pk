<?php

namespace App\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends \FOS\UserBundle\Controller\RegistrationController
{
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws AccessDeniedException
     *
     * @Route("/register/confirmed", name="fos_user_registration_confirmed")
     */
    public function confirmedAction(Request $request): RedirectResponse
    {
        $user = $this->getUser();
        if (!\is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return new RedirectResponse(
            $this->generateUrl('homepage')
        );
    }
}