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
     * @var string|null $faculty
     *
     * @ORM\Column(type="string", name="faculty", length=255, nullable=false)
     */
    private $faculty;

    /**
     * @var int|null $degree
     *
     * @ORM\Column(type="integer", name="degree", nullable=false)
     */
    private $degree;

    /**
     * @var int|null $year
     *
     * @ORM\Column(type="integer", name="year", nullable=false)
     */
    private $year;

    /**
     * @var string|null $group
     *
     * @ORM\Column(type="string", name="`group`", length=255, nullable=false)
     */
    private $group;

    /**
     * @var string|null $subgroup
     *
     * @ORM\Column(type="string", name="subgroup", length=255, nullable=true)
     */
    private $subgroup;

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
     * @return null|string
     */
    public function getFaculty(): ?string
    {
        return $this->faculty;
    }

    /**
     * @param null|string $faculty
     */
    public function setFaculty(?string $faculty): void
    {
        $this->faculty = $faculty;
    }

    /**
     * @return int|null
     */
    public function getDegree(): ?int
    {
        return $this->degree;
    }

    /**
     * @param int|null $degree
     */
    public function setDegree(?int $degree): void
    {
        $this->degree = $degree;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @param int|null $year
     */
    public function setYear(?int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return null|string
     */
    public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * @param null|string $group
     */
    public function setGroup(?string $group): void
    {
        $this->group = $group;
    }

    /**
     * @return null|string
     */
    public function getSubgroup(): ?string
    {
        return $this->subgroup;
    }

    /**
     * @param null|string $subgroup
     */
    public function setSubgroup(?string $subgroup): void
    {
        $this->subgroup = $subgroup;
    }
}