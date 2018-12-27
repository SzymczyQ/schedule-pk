<?php

namespace App\Service\Manager;

use App\Entity\Schedule;
use Psr\Http\Message\RequestInterface;

/**
 * Class GoogleCalendarManager
 * @package App\Service\Manager
 */
class GoogleCalendarManager
{
    /**
     * @param \Google_Service_Calendar $service
     * @param string $summary
     * @return null|string
     */
    public function getCalendarIdByName(\Google_Service_Calendar $service, string $summary):? string
    {
        $calendarList = $service->calendarList->listCalendarList();

        /** @var \Google_Service_Calendar_CalendarListEntry $calendar */
        foreach ($calendarList as $calendar) {
            if ($calendar->getSummary() === $summary) {
                return $calendar->getId();
            }
        }

        return null;
    }

    /**
     * @param \Google_Service_Calendar $service
     * @param string $calendarName
     * @return string
     */
    public function createCalendar(\Google_Service_Calendar $service, string $calendarName): string
    {
        $calendar = new \Google_Service_Calendar_Calendar();
        $calendar->setSummary($calendarName);
        $calendar->setTimeZone('Europe/Warsaw');
        $calendar = $service->calendars->insert($calendar);

        return $calendar->getId();
    }

    /**
     * @param \Google_Service_Calendar $service
     * @param Schedule $schedule
     * @param string $calendarId
     * @return \Google_Service_Calendar_Event|RequestInterface
     */
    public function createEvent(\Google_Service_Calendar $service, Schedule $schedule, string $calendarId)
    {
        $start = $schedule->getClassesStartTime();
        $end = $schedule->getClassesEndTime();
        $date = $schedule->getClassesDate();

        $event = new \Google_Service_Calendar_Event([
            'summary' => $schedule->getClassesName(),
            'location' => $schedule->getPlace(),
            'description' => $schedule->getLecturerName(),
            'start' => [
                'dateTime' => $date->format('Y-m-d') . 'T' . $start->format('H:i:s'),
                'timeZone' => 'Europe/Warsaw',
            ],
            'end' => [
                'dateTime' => $date->format('Y-m-d') . 'T' . $end->format('H:i:s'),
                'timeZone' => 'Europe/Warsaw',
            ]
        ]);

        return $service->events->insert($calendarId, $event);
    }
}