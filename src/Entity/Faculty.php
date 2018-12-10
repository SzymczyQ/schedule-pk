<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="faculties",
 * )
 * @ORM\Entity(repositoryClass="App\Repository\FacultyRepository")
 */
class Faculty
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
     * @var string|null $name
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * One Faculty has many Cycles. This is the inverse side.
     *
     * @var Cycle[]|null $cycles
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Cycle",
     *     mappedBy="faculty",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=TRUE
     * )
     */
    private $cycles;

    /**
     * Faculty constructor.
     */
    public function __construct()
    {
        $this->cycles = new ArrayCollection();
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

    /**
     * @return Collection|null
     */
    public function getCycles(): ?Collection
    {
        return $this->cycles;
    }

    /**
     * @param Collection|null $cycles
     */
    public function setCycles(?Collection $cycles): void
    {
        $this->cycles = $cycles;
    }

    /**
     * @param Cycle $cycle
     */
    public function addCycle(Cycle $cycle): void
    {
        if (!$this->cycles->contains($cycle)) {
            $this->cycles->add($cycle);
            $cycle->setFaculty($this);
        }
    }

    /**
     * @param Cycle $cycle
     */
    public function removeCycle(Cycle $cycle): void
    {
        if ($this->cycles->contains($cycle)) {
            $this->cycles->removeElement($cycle);
            $cycle->setFaculty(null);
        }
    }
}