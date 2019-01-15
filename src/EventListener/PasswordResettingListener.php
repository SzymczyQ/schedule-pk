<?php

namespace App\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class PasswordResettingListener
 * @package App\EventListener
 */
class PasswordResettingListener implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    /**
     * PasswordResettingListener constructor.
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FOSUserEvents::RESETTING_RESET_SUCCESS => 'onPasswordResettingSuccess',
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function onPasswordResettingSuccess(FormEvent $event)
    {
        $url = $this->router->generate('homepage');
        $event->setResponse(new RedirectResponse($url));
    }
}