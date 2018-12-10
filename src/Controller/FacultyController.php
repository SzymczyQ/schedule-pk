<?php

namespace App\Controller;

use App\Entity\Faculty;
use App\Form\FacultyFormType;
use App\Repository\FacultyRepository;
use App\Service\Manager\FlashBagManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class FacultyController
 * @package App\Controller
 *
 * @Route("/admin")
 */
class FacultyController extends AbstractController
{
    /**
     * @var FacultyRepository $facultyRepository
     */
    private $facultyRepository;

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
     * FacultyController constructor.
     * @param FacultyRepository $facultyRepository
     * @param EntityManagerInterface $entityManager
     * @param FlashBagManager $flashBagManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        FacultyRepository $facultyRepository,
        EntityManagerInterface $entityManager,
        FlashBagManager $flashBagManager,
        TranslatorInterface $translator
    ) {
        $this->facultyRepository = $facultyRepository;
        $this->entityManager = $entityManager;
        $this->flashBagManager = $flashBagManager;
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/faculty", name="faculty")
     * @Method({"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $faculty = new Faculty();
        $facultyForm = $this->createForm(
            FacultyFormType::class,
            $faculty
        );

        $facultyForm->handleRequest($request);
        if ($facultyForm->isSubmitted()) {
            if ($facultyForm->isValid()) {

                try {
                    $this->entityManager->persist($faculty);
                    $this->entityManager->flush();

                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_SUCCESS,
                        $this->translator->trans('faculty_form.messages.success')
                    );
                } catch (\Exception | \Throwable $exception) {
                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_ERROR,
                        $this->translator->trans('faculty_form.messages.error')
                    );
                }

                return $this->redirect(
                    $request->getUri()
                );
            }

            $this->flashBagManager->add(
                FlashBagManager::TYPE_WARNING,
                $this->translator->trans('faculty_form.messages.warning')
            );
        }

        return $this->render('faculty/index.html.twig', [
            'faculties' => $this->facultyRepository->findAll(),
            'facultyForm' => $facultyForm->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Faculty $faculty
     * @return Response
     *
     * @Route(
     *     "/faculty/{faculty}/delete",
     *     name="admin_faculty_delete",
     *     requirements={"faculty": "\d+"}
     * )
     * @Method({"POST"})
     */
    public function removeFaculty(Request $request, Faculty $faculty): Response
    {
        try {
            $this->entityManager->remove($faculty);
            $this->entityManager->flush();

            $this->flashBagManager->add(
                FlashBagManager::TYPE_SUCCESS,
                $this->translator->trans('delete_faculty_form.messages.success')
            );
        } catch (\Exception | \Throwable $exception) {
            $this->flashBagManager->add(
                FlashBagManager::TYPE_ERROR,
                $this->translator->trans('delete_faculty_form.messages.error')
            );
        }

        return $this->redirect(
            $this->generateUrl('faculty')
        );
    }

    /**
     * @param Request $request
     * @param Faculty $faculty
     * @return Response
     *
     * @Route(
     *     "/faculty/{faculty}/edit",
     *     name="admin_faculty_edit",
     *     requirements={"faculty": "\d+"}
     * )
     * @Method({"GET", "POST"})
     */
    public function editFaculty(Request $request, Faculty $faculty): Response
    {
        $facultyForm = $this->createForm(
            FacultyFormType::class,
            $faculty
        );

        $facultyForm->handleRequest($request);
        if ($facultyForm->isSubmitted()) {
            if ($facultyForm->isValid()) {
                try {
                    $this->entityManager->flush();

                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_SUCCESS,
                        $this->translator->trans('edit_faculty_form.messages.success')
                    );
                } catch (\Exception | \Throwable $exception) {
                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_ERROR,
                        $this->translator->trans('edit_faculty_form.messages.error')
                    );
                }

                return $this->redirect(
                    $this->generateUrl('faculty')
                );
            }

            $this->flashBagManager->add(
                FlashBagManager::TYPE_WARNING,
                $this->translator->trans('edit_faculty_form.messages.warning')
            );
        }

        return $this->render('faculty/faculty_edit.html.twig', [
            'facultyForm' => $facultyForm->createView()
        ]);
    }
}