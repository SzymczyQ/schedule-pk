<?php

namespace App\Controller;

use App\Repository\ConfigRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @var ConfigRepository $configRepository
     */
    private $configRepository;

    /**
     * AdminController constructor.
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/", name="admin")
     * @Method({"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        return $this->render('admin/index.html.twig', [
            'parameters' => $this->configRepository->findAll()
        ]);
    }
}