<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="cycles",
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CycleRepository")
 */
class Cycle
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
     * Many Cycles have one Faculty. This is the owning side.
     *
     * @var Faculty|null $faculty
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Faculty", inversedBy="cycles")
     * @ORM\JoinColumn(name="faculty_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $faculty;

    /**
     * One Year has many Cycles. This is the inverse side.
     *
     * @var Year[]|null $years
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Year",
     *     mappedBy="cycle",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=TRUE
     * )
     */
    private $years;

    /**
     * @var string|null $name
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * Cycle constructor.
     */
    public function __construct()
    {
        $this->years = new ArrayCollection();
    }

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
     * @return Faculty|null
     */
    public function getFaculty(): ?Faculty
    {
        return $this->faculty;
    }

    /**
     * @param Faculty|null $faculty
     */
    public function setFaculty(?Faculty $faculty): void
    {
        $this->faculty = $faculty;
    }

    /**
     * @return Year[]|null
     */
    public function getYears(): ?array
    {
        return $this->years;
    }

    /**
     * @param Year[]|null $years
     */
    public function setYears(?array $years): void
    {
        $this->years = $years;
    }

    /**
     * @param Year $year
     */
    public function addYear(Year $year): void
    {
        if (!$this->years->contains($year)) {
            $this->years->add($year);
            $year->setCycle($this);
        }
    }

    /**
     * @param Year $year
     */
    public function removeYear(Year $year): void
    {
        if ($this->years->contains($year)) {
            $this->years->removeElement($year);
            $year->setCycle(null);
        }
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}