<?php

namespace App\Repository;

use App\Entity\UserSchoolInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class UserSchoolInfoRepository
 * @package App\Repository
 */
class UserSchoolInfoRepository extends ServiceEntityRepository
{
    /**
     * UserSchoolInfoRepository constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, UserSchoolInfo::class);
    }
}