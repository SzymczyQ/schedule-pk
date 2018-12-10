<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * @ORM\Table(
 *     name="years",
 * )
 * @ORM\Entity(repositoryClass="App\Repository\YearRepository")
 */
class Year
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
     * Many Years have one Cycle. This is the owning side.
     *
     * @var Cycle|null $cycle
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Cycle", inversedBy="years")
     * @ORM\JoinColumn(name="cycle_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $cycle;

    /**
     * One Year has many Groups. This is the inverse side.
     *
     * @var Collection|null $groups
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Group",
     *     mappedBy="year",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=TRUE
     * )
     */
    private $groups;

    /**
     * Year constructor.
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
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
     * @return Cycle|null
     */
    public function getCycle(): ?Cycle
    {
        return $this->cycle;
    }

    /**
     * @param Cycle|null $cycle
     */
    public function setCycle(?Cycle $cycle): void
    {
        $this->cycle = $cycle;
    }

    /**
     * @return null|Collection
     */
    public function getGroups(): ?Collection
    {
        return $this->groups;
    }

    /**
     * @param null|Collection $groups
     */
    public function setGroups(?Collection $groups): void
    {
        $this->groups = $groups;
    }

    /**
     * @param Group $group
     */
    public function addGroup(Group $group): void
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
            $group->setYear($this);
        }
    }

    /**
     * @param Group $group
     */
    public function removeGroup(Group $group): void
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->setYear(null);
        }
    }
}