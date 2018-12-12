<?php

namespace App\Twig;

use App\Entity\Group;
use App\Repository\GroupRepository;

/**
 * Class GroupExtension
 * @package App\Twig
 */
class GroupExtension extends \Twig_Extension
{
    /**
     * @var GroupRepository $groupRepository
     */
    private $groupRepository;

    /**
     * GroupExtension constructor.
     * @param GroupRepository $groupRepository
     */
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('getGroupById', [$this, 'getGroupById']),
        ];
    }

    /**
     * @param int $groupId
     * @return Group|object|null
     */
    public function getGroupById(int $groupId):? Group
    {
        return $this->groupRepository
            ->find($groupId);
    }
}