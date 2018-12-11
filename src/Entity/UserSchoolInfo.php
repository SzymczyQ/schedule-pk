<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class UserSchoolInfo
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="user_school_data",
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserSchoolInfoRepository")
 */
class UserSchoolInfo
{
    use TimestampableEntity;

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Many UserSchoolInfos have one User. This is the owning side.
     *
     * @var User|null $user
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userSchoolInfos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * Many UserSchoolInfo have one Group. This is the owning side.
     *
     * @var Group|null $group
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $group;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Group|null
     */
    public function getGroup(): ?Group
    {
        return $this->group;
    }

    /**
     * @param Group|null $group
     */
    public function setGroup(?Group $group): void
    {
        $this->group = $group;
    }
}