<?php

namespace App\Controller;

use App\Form\UserInfoFormType;
use App\Service\Manager\FlashBagManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

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
     * @var FlashBagManager $flashBagManager
     */
    private $flashBagManager;

    /**
     * @var TranslatorInterface $translator
     */
    private $translator;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $entityManager
     * @param FlashBagManager $flashBagManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        FlashBagManager $flashBagManager,
        TranslatorInterface $translator
    ) {
        $this->entityManager = $entityManager;
        $this->flashBagManager = $flashBagManager;
        $this->translator = $translator;
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

            $this->flashBagManager->add(
                FlashBagManager::TYPE_SUCCESS,
                $this->translator->trans('user_info_form.messages.success')
            );
        }

        return $this->render('user/index.html.twig', [
            'userInfoForm' => $userInfoForm->createView()
        ]);
    }
}