<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Schedule;
use App\Repository\ScheduleRepository;
use App\Service\Manager\FlashBagManager;
use App\Service\Manager\GoogleApiManager;
use App\Service\Manager\GoogleCalendarManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/calendar")
 *
 * Class CalendarController
 * @package App\Controller
 */
class CalendarController extends AbstractController
{
    /**
     * @var GoogleApiManager $googleApiManager
     */
    private $googleApiManager;

    /**
     * @var ScheduleRepository $scheduleRepository
     */
    private $scheduleRepository;

    /**
     * @var SessionInterface $session
     */
    private $session;

    /**
     * @var FlashBagManager $flashBagManager
     */
    private $flashBagManager;

    /**
     * @var GoogleCalendarManager $calendarManager
     */
    private $calendarManager;

    /**
     * @var TranslatorInterface $translator
     */
    private $translator;

    /**
     * CalendarController constructor.
     * @param GoogleApiManager $googleApiManager
     * @param ScheduleRepository $scheduleRepository
     * @param SessionInterface $session
     * @param FlashBagManager $flashBagManager
     * @param GoogleCalendarManager $calendarManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        GoogleApiManager $googleApiManager,
        ScheduleRepository $scheduleRepository,
        SessionInterface $session,
        FlashBagManager $flashBagManager,
        GoogleCalendarManager $calendarManager,
        TranslatorInterface $translator
    ) {
        $this->googleApiManager = $googleApiManager;
        $this->scheduleRepository = $scheduleRepository;
        $this->session = $session;
        $this->flashBagManager = $flashBagManager;
        $this->calendarManager = $calendarManager;
        $this->translator = $translator;
    }

    /**
     * @Route("/connect", name="calendar_connect")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function googleConnect(Request $request)
    {
        $this->session->set('code', $request->get('code'));

        return $this->redirect(
            $request->get('state')
        );
    }

    /**
     * @Route("/{group}/add", name="calendar_add_schedule")
     *
     * @param Request $request
     * @param Group $group
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addSchedule(Request $request, Group $group)
    {
        $redirectUrl = $this->generateUrl(
            'calendar_add_schedule',
            [
                'group' => $group->getId()
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        try {
            $client = $this->googleApiManager->getClient($request, $redirectUrl);
            if (is_string($client)) {
                return $this->redirect($client);
            }

            $calendarName = 'Podział PK - ' . $group->getName();
            $service = new \Google_Service_Calendar($client);

            $calendarId =  $this->calendarManager->getCalendarIdByName($service, $calendarName);
            if (null !== $calendarId) {
                $service->calendars->delete($calendarId);
            }
            $calendarId = $this->calendarManager->createCalendar($service, $calendarName);

            $schedules = $this->scheduleRepository
                ->getSchedulesByGroup($group);

            $client->setUseBatch(true);
            $batch = $service->createBatch();

            /** @var Schedule $schedule */
            foreach ($schedules as $schedule) {
                $batch->add(
                    $this->calendarManager->createEvent($service, $schedule, $calendarId)
                );
            }

            $batch->execute();
            $client->setUseBatch(false);
        } catch (\Exception | \Throwable $exception) {
            $this->flashBagManager
                ->add(
                    FlashBagManager::TYPE_ERROR,
                    $this->translator->trans('add_calendar.error')
                );
        }

        $this->flashBagManager
            ->add(
                FlashBagManager::TYPE_SUCCESS,
                $this->translator->trans('add_calendar.success')
            );

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/{group}/remove", name="calendar_remove_schedule")
     *
     * @param Request $request
     * @param Group $group
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeSchedule(Request $request, Group $group)
    {
        $redirectUrl = $this->generateUrl(
            'calendar_remove_schedule',
            [
                'group' => $group->getId()
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        try {
            $client = $this->googleApiManager->getClient($request, $redirectUrl);
            if (is_string($client)) {
                return $this->redirect($client);
            }

            $calendarName = 'Podział PK - ' . $group->getName();
            $service = new \Google_Service_Calendar($client);

            $calendarId =  $this->calendarManager->getCalendarIdByName($service, $calendarName);
            if (null !== $calendarId) {
                $service->calendars->delete($calendarId);
                $this->flashBagManager
                    ->add(
                        FlashBagManager::TYPE_SUCCESS,
                        $this->translator->trans('remove_calendar.success')
                    );
            } else {
                $this->flashBagManager
                    ->add(
                        FlashBagManager::TYPE_WARNING,
                        $this->translator->trans('remove_calendar.warning')
                    );
            }
        } catch (\Exception | \Throwable $exception) {
            $this->flashBagManager
                ->add(
                    FlashBagManager::TYPE_ERROR,
                    $this->translator->trans('remove_calendar.error')
                );
        }

        return $this->redirectToRoute('homepage');
    }
}