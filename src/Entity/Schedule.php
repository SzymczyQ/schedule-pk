<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Schedule
 * @package App\Entity
 *
 * @ORM\Table(
 *     name="schedule",
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleRepository")
 */
class Schedule
{
    /**
     * @var integer|null $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many Schedules have one Group. This is the owning side.
     *
     * @var Group|null $group
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $group;

    /**
     * @var \DateTime $classesDate
     *
     * @ORM\Column(name="classes_date", type="date", nullable=true)
     */
    private $classesDate;

    /**
     * @var \DateTime|null $classesStartTime
     *
     * @ORM\Column(name="classes_start_time", type="time", nullable=true)
     */
    private $classesStartTime;

    /**
     * @var \DateTime|null $classesEndTime
     *
     * @ORM\Column(name="classes_end_time", type="time", nullable=true)
     */
    private $classesEndTime;

    /**
     * @var string|null $classesName
     *
     * @ORM\Column(name="classes_Name", type="string", length=100, nullable=true)
     */
    private $classesName;

    /**
     * @var string|null $lecturerName
     *
     * @ORM\Column(name="lecturer_name", type="string", length=100, nullable=true)
     */
    private $lecturerName;

    /**
     * @var string|null $place
     *
     * @ORM\Column(name="place", type="string", length=100, nullable=true)
     */
    private $place;

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

    /**
     * @return \DateTime
     */
    public function getClassesDate(): \DateTime
    {
        return $this->classesDate;
    }

    /**
     * @param \DateTime $classesDate
     */
    public function setClassesDate(\DateTime $classesDate): void
    {
        $this->classesDate = $classesDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getClassesStartTime(): ?\DateTime
    {
        return $this->classesStartTime;
    }

    /**
     * @param \DateTime|null $classesStartTime
     */
    public function setClassesStartTime(?\DateTime $classesStartTime): void
    {
        $this->classesStartTime = $classesStartTime;
    }

    /**
     * @return \DateTime|null
     */
    public function getClassesEndTime(): ?\DateTime
    {
        return $this->classesEndTime;
    }

    /**
     * @param \DateTime|null $classesEndTime
     */
    public function setClassesEndTime(?\DateTime $classesEndTime): void
    {
        $this->classesEndTime = $classesEndTime;
    }

    /**
     * @return null|string
     */
    public function getClassesName(): ?string
    {
        return $this->classesName;
    }

    /**
     * @param null|string $classesName
     */
    public function setClassesName(?string $classesName): void
    {
        $this->classesName = $classesName;
    }

    /**
     * @return null|string
     */
    public function getLecturerName(): ?string
    {
        return $this->lecturerName;
    }

    /**
     * @param null|string $lecturerName
     */
    public function setLecturerName(?string $lecturerName): void
    {
        $this->lecturerName = $lecturerName;
    }

    /**
     * @return null|string
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * @param null|string $place
     */
    public function setPlace(?string $place): void
    {
        $this->place = $place;
    }
}