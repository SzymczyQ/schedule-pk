<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

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
     * HomepageController constructor.
     * @param ScheduleRepository $scheduleRepository
     * @param Security $security
     */
    public function __construct(ScheduleRepository $scheduleRepository, Security $security)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->security = $security;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('homepage/index.html.twig', [
            'schedules' => $this->scheduleRepository
                ->getUserSchedules(
                    $this->security->getUser()
                )
        ]);
    }
}
