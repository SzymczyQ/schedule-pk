<?php

namespace App\Repository;

use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class GroupRepository
 * @package App\Repository
 */
class GroupRepository extends ServiceEntityRepository
{
    /**
     * GroupRepository constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Group::class);
    }

    /**
     * @return array
     */
    public function getAllRelatedGroupData(): array
    {
        return $this->createQueryBuilder('g', 'g.id')
            ->select('g.id AS groupId')
            ->addSelect('g.name AS groupName')
            ->addSelect('y.name AS yearName')
            ->addSelect('c.name AS cycleName')
            ->addSelect('f.name AS facultyName')
            ->join('g.year', 'y')
            ->join('y.cycle', 'c')
            ->join('c.faculty', 'f')
            ->getQuery()
            ->getResult()
        ;
    }
}