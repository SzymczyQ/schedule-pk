<?php

namespace App\Controller;

use App\Entity\Year;
use App\Form\YearFormType;
use App\Repository\YearRepository;
use App\Service\Manager\FlashBagManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class YearController
 * @package App\Controller
 *
 * @Route("/admin")
 */
class YearController extends AbstractController
{
    /**
     * @var YearRepository $yearRepository
     */
    private $yearRepository;

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
     * YearController constructor.
     * @param YearRepository $yearRepository
     * @param EntityManagerInterface $entityManager
     * @param FlashBagManager $flashBagManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        YearRepository $yearRepository,
        EntityManagerInterface $entityManager,
        FlashBagManager $flashBagManager,
        TranslatorInterface $translator
    ) {
        $this->yearRepository = $yearRepository;
        $this->entityManager = $entityManager;
        $this->flashBagManager = $flashBagManager;
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/year", name="year")
     * @Method({"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $year = new Year();
        $yearForm = $this->createForm(
            YearFormType::class,
            $year
        );

        $yearForm->handleRequest($request);
        if ($yearForm->isSubmitted()) {
            if ($yearForm->isValid()) {

                try {
                    $this->entityManager->persist($year);
                    $this->entityManager->flush();

                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_SUCCESS,
                        $this->translator->trans('year_form.messages.success')
                    );
                } catch (\Exception | \Throwable $exception) {
                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_ERROR,
                        $this->translator->trans('year_form.messages.error')
                    );
                }

                return $this->redirect(
                    $request->getUri()
                );
            }

            $this->flashBagManager->add(
                FlashBagManager::TYPE_WARNING,
                $this->translator->trans('year_form.messages.warning')
            );
        }

        return $this->render('year/index.html.twig', [
            'years' => $this->yearRepository->findAll(),
            'yearForm' => $yearForm->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Year $year
     * @return Response
     *
     * @Route(
     *     "/year/{year}/delete",
     *     name="admin_year_delete",
     *     requirements={"year": "\d+"}
     * )
     * @Method({"POST"})
     */
    public function removeYear(Request $request, Year $year): Response
    {
        try {
            $this->entityManager->remove($year);
            $this->entityManager->flush();

            $this->flashBagManager->add(
                FlashBagManager::TYPE_SUCCESS,
                $this->translator->trans('delete_year_form.messages.success')
            );
        } catch (\Exception | \Throwable $exception) {
            $this->flashBagManager->add(
                FlashBagManager::TYPE_ERROR,
                $this->translator->trans('delete_year_form.messages.error')
            );
        }

        return $this->redirect(
            $this->generateUrl('year')
        );
    }

    /**
     * @param Request $request
     * @param Year $year
     * @return Response
     *
     * @Route(
     *     "/year/{year}/edit",
     *     name="admin_year_edit",
     *     requirements={"year": "\d+"}
     * )
     * @Method({"GET", "POST"})
     */
    public function editYear(Request $request, Year $year): Response
    {
        $yearForm = $this->createForm(
            YearFormType::class,
            $year
        );

        $yearForm->handleRequest($request);
        if ($yearForm->isSubmitted()) {
            if ($yearForm->isValid()) {
                try {
                    $this->entityManager->flush();

                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_SUCCESS,
                        $this->translator->trans('edit_year_form.messages.success')
                    );
                } catch (\Exception | \Throwable $exception) {
                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_ERROR,
                        $this->translator->trans('edit_year_form.messages.error')
                    );
                }

                return $this->redirect(
                    $this->generateUrl('year')
                );
            }

            $this->flashBagManager->add(
                FlashBagManager::TYPE_WARNING,
                $this->translator->trans('edit_year_form.messages.warning')
            );
        }

        return $this->render('year/year_edit.html.twig', [
            'yearForm' => $yearForm->createView()
        ]);
    }
}