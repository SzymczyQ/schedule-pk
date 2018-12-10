<?php

namespace App\Controller;

use App\Entity\Cycle;
use App\Form\CycleFormType;
use App\Repository\CycleRepository;
use App\Service\Manager\FlashBagManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class CycleController
 * @package App\Controller
 *
 * @Route("/admin")
 */
class CycleController extends AbstractController
{
    /**
     * @var CycleRepository $cycleRepository
     */
    private $cycleRepository;

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
     * CycleController constructor.
     * @param CycleRepository $cycleRepository
     * @param EntityManagerInterface $entityManager
     * @param FlashBagManager $flashBagManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        CycleRepository $cycleRepository,
        EntityManagerInterface $entityManager,
        FlashBagManager $flashBagManager,
        TranslatorInterface $translator
    ) {
        $this->cycleRepository = $cycleRepository;
        $this->entityManager = $entityManager;
        $this->flashBagManager = $flashBagManager;
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/cycle", name="cycle")
     * @Method({"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $cycle = new Cycle();
        $cycleForm = $this->createForm(
            CycleFormType::class,
            $cycle
        );

        $cycleForm->handleRequest($request);
        if ($cycleForm->isSubmitted()) {
            if ($cycleForm->isValid()) {

                try {
                    $this->entityManager->persist($cycle);
                    $this->entityManager->flush();

                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_SUCCESS,
                        $this->translator->trans('cycle_form.messages.success')
                    );
                } catch (\Exception | \Throwable $exception) {
                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_ERROR,
                        $this->translator->trans('cycle_form.messages.error')
                    );
                }

                return $this->redirect(
                    $request->getUri()
                );
            }

            $this->flashBagManager->add(
                FlashBagManager::TYPE_WARNING,
                $this->translator->trans('cycle_form.messages.warning')
            );
        }

        return $this->render('cycle/index.html.twig', [
            'cycles' => $this->cycleRepository->findAll(),
            'cycleForm' => $cycleForm->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Cycle $cycle
     * @return Response
     *
     * @Route(
     *     "/cycle/{cycle}/delete",
     *     name="admin_cycle_delete",
     *     requirements={"cycle": "\d+"}
     * )
     * @Method({"POST"})
     */
    public function removeCycle(Request $request, Cycle $cycle): Response
    {
        try {
            $this->entityManager->remove($cycle);
            $this->entityManager->flush();

            $this->flashBagManager->add(
                FlashBagManager::TYPE_SUCCESS,
                $this->translator->trans('delete_cycle_form.messages.success')
            );
        } catch (\Exception | \Throwable $exception) {
            $this->flashBagManager->add(
                FlashBagManager::TYPE_ERROR,
                $this->translator->trans('delete_cycle_form.messages.error')
            );
        }

        return $this->redirect(
            $this->generateUrl('cycle')
        );
    }

    /**
     * @param Request $request
     * @param Cycle $cycle
     * @return Response
     *
     * @Route(
     *     "/cycle/{cycle}/edit",
     *     name="admin_cycle_edit",
     *     requirements={"cycle": "\d+"}
     * )
     * @Method({"GET", "POST"})
     */
    public function editCycle(Request $request, Cycle $cycle): Response
    {
        $cycleForm = $this->createForm(
            CycleFormType::class,
            $cycle
        );

        $cycleForm->handleRequest($request);
        if ($cycleForm->isSubmitted()) {
            if ($cycleForm->isValid()) {
                try {
                    $this->entityManager->flush();

                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_SUCCESS,
                        $this->translator->trans('edit_cycle_form.messages.success')
                    );
                } catch (\Exception | \Throwable $exception) {
                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_ERROR,
                        $this->translator->trans('edit_cycle_form.messages.error')
                    );
                }

                return $this->redirect(
                    $this->generateUrl('cycle')
                );
            }

            $this->flashBagManager->add(
                FlashBagManager::TYPE_WARNING,
                $this->translator->trans('edit_cycle_form.messages.warning')
            );
        }

        return $this->render('cycle/cycle_edit.html.twig', [
            'cycleForm' => $cycleForm->createView()
        ]);
    }
}