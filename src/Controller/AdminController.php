<?php

namespace App\Controller;

use App\Entity\Config;
use App\Form\ConfigFormType;
use App\Repository\ConfigRepository;
use App\Service\Manager\FlashBagManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

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
     * AdminController constructor.
     * @param ConfigRepository $configRepository
     * @param EntityManagerInterface $entityManager
     * @param FlashBagManager $flashBagManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        ConfigRepository $configRepository,
        EntityManagerInterface $entityManager,
        FlashBagManager $flashBagManager,
        TranslatorInterface $translator
    ) {
        $this->configRepository = $configRepository;
        $this->entityManager = $entityManager;
        $this->flashBagManager = $flashBagManager;
        $this->translator = $translator;
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
        $config = new Config();
        $configForm = $this->createForm(
            ConfigFormType::class,
            $config
        );

        $configForm->handleRequest($request);
        if ($configForm->isSubmitted()) {
            if ($configForm->isValid()) {
                $this->entityManager->persist($config);
                $this->entityManager->flush();

                $this->flashBagManager->add(
                    FlashBagManager::TYPE_SUCCESS,
                    $this->translator->trans('config_form.messages.success')
                );

                return $this->redirect(
                    $request->getUri()
                );
            }

            $this->flashBagManager->add(
                FlashBagManager::TYPE_WARNING,
                $this->translator->trans('config_form.messages.warning')
            );
        }

        return $this->render('admin/index.html.twig', [
            'parameters' => $this->configRepository->findAll(),
            'configForm' => $configForm->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Config $config
     * @return Response
     *
     * @Route(
     *     "/config/{config}/delete",
     *     name="admin_config_delete",
     *     requirements={"config": "\d+"}
     * )
     * @Method({"POST"})
     */
    public function removeConfig(Request $request, Config $config): Response
    {
        try {
            $this->entityManager->remove($config);
            $this->entityManager->flush();

            $this->flashBagManager->add(
                FlashBagManager::TYPE_SUCCESS,
                $this->translator->trans('delete_config_form.messages.success')
            );
        } catch (\Exception | \Throwable $exception) {
            $this->flashBagManager->add(
                FlashBagManager::TYPE_ERROR,
                $this->translator->trans('delete_config_form.messages.error')
            );
        }

        return $this->redirect(
            $this->generateUrl('admin')
        );
    }

    /**
     * @param Request $request
     * @param Config $config
     * @return Response
     *
     * @Route(
     *     "/config/{config}/edit",
     *     name="admin_config_edit",
     *     requirements={"config": "\d+"}
     * )
     * @Method({"GET", "POST"})
     */
    public function editConfig(Request $request, Config $config): Response
    {
        $configForm = $this->createForm(
            ConfigFormType::class,
            $config
        );

        $configForm->handleRequest($request);
        if ($configForm->isSubmitted()) {
            if ($configForm->isValid()) {
                $this->entityManager->flush();

                $this->flashBagManager->add(
                    FlashBagManager::TYPE_SUCCESS,
                    $this->translator->trans('edit_config_form.messages.success')
                );

                return $this->redirect(
                    $this->generateUrl('admin')
                );
            }

            $this->flashBagManager->add(
                FlashBagManager::TYPE_WARNING,
                $this->translator->trans('edit_config_form.messages.warning')
            );
        }

        return $this->render('admin/config_edit.html.twig', [
            'configForm' => $configForm->createView()
        ]);
    }
}