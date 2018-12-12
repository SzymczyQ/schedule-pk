<?php

namespace App\Repository;

use App\Entity\Schedule;
use App\Entity\User;
use App\Entity\UserSchoolInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ScheduleRepository
 * @package App\Repository
 */
class ScheduleRepository extends ServiceEntityRepository
{
    /**
     * ScheduleRepository constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Schedule::class);
    }

    /**
     * @param User|UserInterface $user
     * @return mixed
     */
    public function getUserSchedules(User $user): array
    {
        $userGroups = [];
        $userSchoolInfos = $user->getUserSchoolInfos();

        /** @var UserSchoolInfo $userSchoolInfo */
        foreach ($userSchoolInfos as $userSchoolInfo) {
            $userGroups[] = $userSchoolInfo->getGroup()->getId();
        }

        $result = [];
        $schedules = $this->createQueryBuilder('s')
            ->select('s')
            ->join('s.group', 'g')
            ->where('g.id IN(:groupIds)')
            ->setParameter('groupIds', $userGroups)
            ->orderBy('s.classesDate')
            ->addOrderBy('s.classesStartTime')
            ->getQuery()
            ->getResult();

        /** @var Schedule $schedule */
        foreach ($schedules as $schedule) {
            $result[$schedule->getGroup()->getId()][] = $schedule;
        }

        return $result;
    }
}