<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Year;
use App\Form\GroupFormType;
use App\Form\YearFormType;
use App\Repository\GroupRepository;
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
 * Class GroupController
 * @package App\Controller
 *
 * @Route("/admin")
 */
class GroupController extends AbstractController
{
    /**
     * @var GroupRepository $groupRepository
     */
    private $groupRepository;

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
     * GroupController constructor.
     * @param GroupRepository $groupRepository
     * @param EntityManagerInterface $entityManager
     * @param FlashBagManager $flashBagManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        GroupRepository $groupRepository,
        EntityManagerInterface $entityManager,
        FlashBagManager $flashBagManager,
        TranslatorInterface $translator
    ) {
        $this->groupRepository = $groupRepository;
        $this->entityManager = $entityManager;
        $this->flashBagManager = $flashBagManager;
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/group", name="group")
     * @Method({"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $group = new Group();
        $groupForm = $this->createForm(
            GroupFormType::class,
            $group
        );

        $groupForm->handleRequest($request);
        if ($groupForm->isSubmitted()) {
            if ($groupForm->isValid()) {

                try {
                    $this->entityManager->persist($group);
                    $this->entityManager->flush();

                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_SUCCESS,
                        $this->translator->trans('group_form.messages.success')
                    );
                } catch (\Exception | \Throwable $exception) {
                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_ERROR,
                        $this->translator->trans('group_form.messages.error')
                    );
                }

                return $this->redirect(
                    $request->getUri()
                );
            }

            $this->flashBagManager->add(
                FlashBagManager::TYPE_WARNING,
                $this->translator->trans('group_form.messages.warning')
            );
        }

        return $this->render('group/index.html.twig', [
            'groups' => $this->groupRepository->findAll(),
            'groupForm' => $groupForm->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Group $group
     * @return Response
     *
     * @Route(
     *     "/group/{group}/delete",
     *     name="admin_group_delete",
     *     requirements={"group": "\d+"}
     * )
     * @Method({"POST"})
     */
    public function removeGroup(Request $request, Group $group): Response
    {
        try {
            $this->entityManager->remove($group);
            $this->entityManager->flush();

            $this->flashBagManager->add(
                FlashBagManager::TYPE_SUCCESS,
                $this->translator->trans('delete_group_form.messages.success')
            );
        } catch (\Exception | \Throwable $exception) {
            $this->flashBagManager->add(
                FlashBagManager::TYPE_ERROR,
                $this->translator->trans('delete_group_form.messages.error')
            );
        }

        return $this->redirect(
            $this->generateUrl('group')
        );
    }

    /**
     * @param Request $request
     * @param Group $group
     * @return Response
     *
     * @Route(
     *     "/group/{group}/edit",
     *     name="admin_group_edit",
     *     requirements={"group": "\d+"}
     * )
     * @Method({"GET", "POST"})
     */
    public function editGroup(Request $request, Group $group): Response
    {
        $groupForm = $this->createForm(
            GroupFormType::class,
            $group
        );

        $groupForm->handleRequest($request);
        if ($groupForm->isSubmitted()) {
            if ($groupForm->isValid()) {
                try {
                    $this->entityManager->flush();

                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_SUCCESS,
                        $this->translator->trans('edit_group_form.messages.success')
                    );
                } catch (\Exception | \Throwable $exception) {
                    $this->flashBagManager->add(
                        FlashBagManager::TYPE_ERROR,
                        $this->translator->trans('edit_group_form.messages.error')
                    );
                }

                return $this->redirect(
                    $this->generateUrl('group')
                );
            }

            $this->flashBagManager->add(
                FlashBagManager::TYPE_WARNING,
                $this->translator->trans('edit_group_form.messages.warning')
            );
        }

        return $this->render('group/group_edit.html.twig', [
            'groupForm' => $groupForm->createView()
        ]);
    }
}