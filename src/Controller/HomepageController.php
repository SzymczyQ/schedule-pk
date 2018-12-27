<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use App\Service\Manager\GoogleApiManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class HomepageController
 * @package App\Controller
 *
 * @Route("/")
 */
class HomepageController extends Controller
{
    /**
     * @var ScheduleRepository $scheduleRepository
     */
    private $scheduleRepository;

    /**
     * @var Security $security
     */
    private $security;

    /**
     * @var GoogleApiManager $googleApiManager
     */
    private $googleApiManager;

    /**
     * HomepageController constructor.
     * @param ScheduleRepository $scheduleRepository
     * @param Security $security
     * @param GoogleApiManager $googleApiManager
     */
    public function __construct(ScheduleRepository $scheduleRepository, Security $security, GoogleApiManager $googleApiManager)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->security = $security;
        $this->googleApiManager = $googleApiManager;
    }

    /**
     * @Route("/", name="homepage")
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->render('homepage/index.html.twig', [
            'schedules' => $this->scheduleRepository
                ->getUserSchedules(
                    $this->security->getUser()
                )
        ]);
    }
}
