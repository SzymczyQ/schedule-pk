<?php

namespace App\Controller;

use App\Form\UserInfoFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/", name="user")
     * @Method({"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $userInfoForm = $this->createForm(
            UserInfoFormType::class,
            $this->getUser()
        );

        $userInfoForm->handleRequest($request);
        if ($userInfoForm->isSubmitted() && $userInfoForm->isValid()) {
            $this->entityManager->flush();
        }

        return $this->render('user/index.html.twig', [
            'userInfoForm' => $userInfoForm->createView()
        ]);
    }
}