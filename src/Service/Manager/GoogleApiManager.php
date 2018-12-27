<?php

namespace App\Service\Manager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class GoogleApiManager
 * @package App\Service\Manager
 */
class GoogleApiManager
{
    /**
     * @var \Google_Client $googleClient
     */
    private $googleClient;

    /**
     * @var SessionInterface $session
     */
    private $session;

    /**
     * @var RouterInterface $router
     */
    private $router;

    /**
     * GoogleApiController constructor.
     * @param \Google_Client $googleClient
     * @param SessionInterface $session
     * @param RouterInterface $router
     */
    public function __construct(\Google_Client $googleClient, SessionInterface $session, RouterInterface $router)
    {
        $this->googleClient = $googleClient;
        $this->googleClient->setScopes(\Google_Service_Calendar::CALENDAR);
        $this->googleClient->setAccessType('offline');

        $guzzleClient = new \GuzzleHttp\Client();
        $this->googleClient->setHttpClient($guzzleClient);

        $this->session = $session;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param string $redirect
     * @return \Google_Client|string
     */
    public function getClient(Request $request, string $redirect)
    {
        $code = $this->session->get('code', null);

        $this->googleClient->setScopes([\Google_Service_Calendar::CALENDAR]);
        $this->googleClient->setRedirectUri(
            $this->router->generate('calendar_connect', [], UrlGeneratorInterface::ABSOLUTE_URL)
        );
        $this->googleClient->setState($redirect);

        $guzzleClient = new \GuzzleHttp\Client();
        $this->googleClient->setHttpClient($guzzleClient);

        if ($code === null) {
            return $this->googleClient->createAuthUrl();
        }

        if ($this->session->has('access_token')) {
            $this->googleClient->setAccessToken(
                json_decode(
                    $this->session->get('access_token'),
                    true
                )
            );
        }

        if ($this->googleClient->isAccessTokenExpired()) {
            if ($this->googleClient->getRefreshToken()) {
                $this->googleClient->fetchAccessTokenWithRefreshToken($this->googleClient->getRefreshToken());
            } else {
                $redirected = $this->session->get('redirected', null);
                if ($redirected) {
                    $accessToken = $this->googleClient->fetchAccessTokenWithAuthCode($code);
                    $this->googleClient->setAccessToken($accessToken);

                    $this->session->set('access_token', json_encode($this->googleClient->getAccessToken()));
                    $this->session->set('redirected', false);
                } else {
                    $this->session->set('redirected', true);
                    return $this->googleClient->createAuthUrl();
                }
            }
        }

        return $this->googleClient;
    }
}